<template>
	
<!-- Component container -->
<div>
	
	<!-- Loader - shows if prop data is not yet populated -->
	<div v-if="fetchingModels" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<!-- Table wrapper - only shows after project is loaded -->
	<div v-if="!fetchingModels">
		<div class="row row-padded">
			<h2>Project Timesheets</h2>
			<p class="margin-25-top">
				<h4>
					<strong>Project Identifier:</strong> <span class="label label-success">{{ this.$route.params.project_id }}</span>
				</h4>
			</p>
			<p class="margin-25-top">
				<h4>
					<strong>Total Timesheets:</strong> <span class="label label-success">{{ totalTimesheets }}</span>
				</h4>
			</p>
			<p class="margin-25-top">
				<h4>
					<strong>Accumulated Work Hours:</strong> <span class="label label-success">{{ totalWorkHours }}</span>
				</h4>
			</p>
			<p class="margin-25-top">
				<h4>
					<strong>Accumulated Travel Hours:</strong> <span class="label label-success">{{  }}</span>
				</h4>
			</p>									
		</div>

		<!-- Tool navigation -->
		<div class="row row-padded margin-25-top">
			<button @click="timesheetFormModal" class="btn btn-default">
				<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add Timesheet
			</button>	
		</div>

		<div v-if="searchResults.models.length > 0">
			
			<div class="row row-padded margin-35-top">
				<timesheet-pill
					v-for="timesheet in searchResults.models"
					:timesheet="timesheet"
				>					
				</timesheet-pill>
			</div>

		</div>
		<div v-else>
			<div class="row row-padded margin-35-top">
				<div class="alert alert-warning text-center">
					<big><strong>Heads up!</strong> You havn't added any timesheets to this project yet</big>
				</div>				
			</div>			
		</div>

		<!-- Modal to hold timesheet form -->
		<modal 
			:modalActive="modalActive" 
			@modal-close="modalActive = false"
		>
			<p slot="body">
				<timesheet-form
					v-if="currentModal == 'Timesheet'"
					:project_id=$route.params.project_id
				>					
				</timesheet-form>
			</p>
			<div slot="footer">
				<button @click="modalActive = false" class="btn btn-primary margin-45-top">Cancel</button>
			</div>
		</modal><!-- / Modal to hold timesheet form -->

	</div>

</div><!-- / Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');
	let modal = require('./../_ui/Modal.vue');
	let timesheet_pill = require('./../timesheet/Timesheet-pill.vue');
	let timesheet_form = require('./../timesheet/Timesheet-form.vue');

	export default{
		components: {
			'modal': modal,
			'timesheet-pill': timesheet_pill,
			'timesheet-form': timesheet_form
		},

		mixins: [api_access],

		data(){
			return {
				currentModal: '',
				// For the form modal
				modalActive: false,
				// Used by API access
				urlToFetch: '/api/dashboard/project-timesheets/'+this.$route.params.project_id,
				// Used by API access
				fetchingModels: false,
				// Results from Laravel pagination json. Used by API access.
				searchResults: {	
					models: []					
				}			
			}
		},

		computed: {
			totalTimesheets(){
				return this.searchResults.models.length;
			},

			totalWorkHours(){
				// Cache total
				var totalHours = parseInt(0);
				// Iterate through each timesheet
				this.searchResults.models.forEach(function(timesheet){
					// If work jobs are present
					if(timesheet.work_jobs.length > 0){
						// Iterate through each job in timesheet
						timesheet.work_jobs.forEach(function(workjob){
							// Update total
							totalHours += parseFloat(workjob.hours_worked);
						});						
					}

				});

				return totalHours.toFixed(2);
			}
		},

		methods: {
			timesheetFormModal(){
				this.currentModal = 'Timesheet';
				this.modalActive = true;
			}
		},

		created(){
			// Retrieve model through API access
			this.getAndSetModels();

			// When the form component alerts this parent of a successful create
			this.$router.app.$on('model-created', model => {
				this.searchResults.models.push(model);	
				this.modalActive = false;						
			});	

			// When the form component alerts this parent a child has been created or updated
			this.$router.app.$on('child-created', model => {
				// Cache context
				var context = this;
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){

						// If the model is a work job
						if(model.job_type){
							// Flag which indicates whether the workjob has been added to cache
							var updated = false;						
							// Iterate through work jobs to determine if a job should be updated or a new 
							// job should be pushed to the collection
							timesheet.work_jobs.forEach(function(workjob){
								// Replace existing updated work job
								if(workjob.id == model.id){
									// Update workjob fields
									workjob.job_type = model.job_type;
									workjob.hours_worked = model.hours_worked;
									workjob.comment = model.comment
									// Update flag
									updated = true;
								}
							});
							// Add a new work job
							if(!updated){
								timesheet.work_jobs.push(model);
							}
						}

						// If the model is a travel job
						if(model.travel_distance){
							console.log(model);
							// Flag which indicates whether the workjob has been added to cache
							var updated = false;						
							// Iterate through work jobs to determine if a job should be updated or a new 
							// job should be pushed to the collection
							timesheet.travel_jobs.forEach(function(travelJob){
								// Replace existing updated work job
								if(travelJob.id == model.id){
									// Update workjob fields
									travelJob.travel_distance = model.travel_distance;
									travelJob.travel_time = model.travel_time;
									travelJob.comment = model.comment
									// Update flag
									updated = true;
								}
							});
							// Add a new work job
							if(!updated){
								timesheet.travel_jobs.push(model);
							}							
						}
						
					}
				});
									
			});	

			// When the form component alerts this parent of a successful create
			this.$router.app.$on('child-deleted', model => {
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
						// If the model is a work job
						if(model.job_type){
							// Flag which indicates whether the workjob has been added to cache
							var updated = false;						
							// Iterate through work jobs to determine if a job should be updated or a new 
							// job should be pushed to the collection
							timesheet.work_jobs.forEach(function(workjob){
								// Replace existing updated work job
								if(workjob.id == model.id){
									var index = timesheet.work_jobs.indexOf(workjob); 
									timesheet.work_jobs.splice(index, 1);
								}
							});
						}

						// If the model is a travel job
						if(model.travel_distance){
							// Flag which indicates whether the workjob has been added to cache
							var updated = false;						
							// Iterate through work jobs to determine if a job should be updated or a new 
							// job should be pushed to the collection
							timesheet.travel_jobs.forEach(function(travelJob){
								// Replace existing updated work job
								if(travelJob.id == model.id){
									var index = timesheet.travel_jobs.indexOf(travelJob); 
									timesheet.travel_jobs.splice(index, 1);
								}
							});
						}						
						
					}
				});										
			});							

		}

	}
	
</script>