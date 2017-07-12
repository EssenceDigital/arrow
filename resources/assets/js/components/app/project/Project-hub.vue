<template>

<!-- Containing div -->
<div>
	<!-- Loader - Shows before the project is loaded -->
	<div v-show="!project" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<!-- Shows once the project is loaded -->
	<div v-show="project">
		<!-- Mount for project table and form -->
		<router-view name="project"
			:project="project"
		>			
		</router-view>

		<hr><!-- Divider -->

		<!-- Once project is approved then these views will be available -->
		<div v-if="project.approval_date">
			<!-- Mount for crew list -->
			<router-view name="crew"
				:crew="project.users"
				:project_id="project.id"
			>		
			</router-view>

			<hr> <!-- Divider -->

			<!-- Mount for timeline table and form -->
			<router-view name="timeline"
				:timeline="project.timeline"
				:project_id="project.id"
			>		
			</router-view>
		</div>
		<!-- Info panel and user hint -->
		<div v-else>
			<div class="row row-padded margin-35-top">
				<div class="alert alert-warning text-center">
					<big><strong>Heads up!</strong> Once the project has an approval date the next steps will become available</big>
				</div>				
			</div>				
		</div>
	
	</div><!-- / Project containter -->
</div><!-- / containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		mixins: [api_access],

		data(){
			return{
				// The project
				project: false
			}
		},

		created(){
			console.log('Project hub created');

			// If the ID is present then do this
			if(this.$route.params.id){
				// Get a fresh version of the requested model
				this.grabModel('/api/projects/' + this.$route.params.id, function(model){
					// Cache retrieved model
					this.project = model;
				});
			}

			// When the form component alerts this parent of a successful update
			this.$router.app.$on('model-updated', model => {
				// Update project if the model is a project
				if(model.province){
					// Update cached model
					this.project = model;
				}

				// Update timeline if the model is a timeline
				if(model.permit_application_date){
					this.project.timeline = model;	
				}							
			});	

			// When this parent is alerted a foreign key model has been created
			this.$router.app.$on('child-created', model => {
				// Update model timeline
				if(model.permit_application_date){
					this.project.timeline = model;	
				}
				// Update model crew
				if(model.first){
					this.project.users.push(model);
				}
				// Update model comments
				if(model.comment){
					this.project.comments.push(model);
				}						
			});

			// When this parent is alerted a crew member has been removed
			this.$router.app.$on('crew-removed', user_id => {
				var context = this;
				// Find the crew member in the model and remove it
				this.project.users.forEach(function(user){
					if(user.id == user_id){
						var index = context.project.users.indexOf(user); 
						context.project.users.splice(index, 1);
					}
				});
			});	

			// When this parent is alreted a comment has been removed
			this.$router.app.$on('comment-removed', comment_id => {
				var context = this;
				// Find the comment in the model and remove it
				this.project.comments.forEach(function(comment){
					if(comment.id == comment_id){
						var index = context.project.comments.indexOf(comment); 
						context.project.comments.splice(index, 1);
					}
				});
			});											
		}
	}
	
</script>