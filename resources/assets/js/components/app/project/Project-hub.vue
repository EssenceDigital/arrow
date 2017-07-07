<template>

<!-- Containing div -->
<div>

	<div v-show="project">
		<!-- Mount for project table and form -->
		<router-view name="project"
			:project="project"
		>			
		</router-view>

		<hr><!-- Divider -->

		<!-- Mount for proposal table and form -->
		<router-view name="proposal"
			:proposal="project.proposal"
			:project_id="project.id"
		>		
		</router-view>	

		<hr><!-- Divider -->

		<div v-if="project.proposal">
			<div v-if="project.proposal.approval_date">
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
			<div v-else>
				<div class="row row-padded margin-35-top">
					<div class="alert alert-warning text-center">
						<big><strong>Heads up!</strong> Once the project has an approval date the next steps will become available</big>
					</div>				
				</div>				
			</div>
		</div>
	</div>

	<!-- Loader - shows if data is fetching -->
	<div v-show="!project" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>		

</div><!-- / containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		mixins: [api_access],

		data(){
			return{
				project: false
			}
		},

		// If an id is in the route then retrieve the model from server
		created(){
			console.log('Project hub created');

			if(this.$route.params.id){
				// Get a fresh version of the requested model
				this.grabModel('/api/projects/' + this.$route.params.id, function(model){
					// Cache retrieved model
					this.project = model;
					console.log(model);
				});
			}

			// When the form component alerts this parent of a successful updated
			this.$router.app.$on('model-updated', model => {
				// Update cached model
				this.project = model;			
			});	

			// When the form component alerts this parent that a proposal has been added
			this.$router.app.$on('child-created', model => {
				// Update model proposal
				if(model.work_type){
					this.project.proposal = model;	
				}
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

			this.$router.app.$on('crew-removed', user_id => {
				var context = this;
				this.project.users.forEach(function(user){
					if(user.id == user_id){
						var index = context.project.users.indexOf(user); 
						context.project.users.splice(index, 1);
					}
				});
			});	

			this.$router.app.$on('comment-removed', comment_id => {
				var context = this;
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