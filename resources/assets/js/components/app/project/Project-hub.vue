<template>

<!-- Containing div -->
<div>

	<div v-show="project">
		<!-- Mount for project table and form -->
		<router-view name="project"
			:project="project"
		>			
		</router-view>

		<!-- Mount for proposal table and form -->
		<router-view name="proposal"
			:proposal="project.proposal"
			:project_id="project.id"
		>		
		</router-view>	

		<div v-show="project.proposal">
			<!-- Mount for timeline table and form -->
			<router-view name="timeline"
				:timeline="project.timeline"
				:project_id="project.id"
			>		
			</router-view>
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
				});
			}

			// When the form component alerts this parent of a successful updated
			this.$router.app.$on('model-updated', model => {
				// Update cached model
				this.project = model;			
			});	

			// When the form component alerts this parent that a proposal has been added
			this.$router.app.$on('child-created', model => {
				// Update cached model
				if(model.work_type){
					this.project.proposal = model;	
				}
				if(model.permit_application_date){
					this.project.timeline = model;	
				}
						
			});								
		}
	}
	
</script>