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

		props: ['project_id'],

		data(){
			return{
				// The project. Get sets by the created() method
				project: false
			}
		},

		created(){
			console.log('Project hub created');

			// If the ID is present then get and set the project
			if(this.project_id){
				// Get a fresh version of the requested model using API access
				this.grabModel('/api/projects/' + this.project_id, function(model){
					// Cache retrieved model
					this.project = model;
				});
			}

			// When the form component alerts this parent of a project update
			this.$router.app.$on('project-updated', model => {
				// Update cached model
				this.project = model;							
			});	

			/* Timeline related events
			*/
			this.$router.app.$on('timeline-created', model => {
				// Update cached model
				this.project.timeline = model;			
			});	
			this.$router.app.$on('timeline-updated', model => {
				// Update cached model
				this.project.timeline = model;			
			});	

			/* Crew related events
			*/
			this.$router.app.$on('crew-created', model => {
				// Update cached model
				this.project.users.push(model);		
			});		
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

			/* Comment related events
			*/
			this.$router.app.$on('comment-created', model => {
				// Update cached model
				this.project.comments.push(model);	
			});
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