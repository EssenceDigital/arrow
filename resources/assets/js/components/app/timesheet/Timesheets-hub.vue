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
			<h2>Project Timesheets <small>(Project {{ this.$route.params.project_id }})</small></h2>
			<p class="margin-25-top">
				Now showing all of your timesheets for this project.
			</p>
			<p class="margin-25-top text-info">
				<span class="glyphicon glyphicon-question-sign"></span>
				Once you add a timesheet you can then add travel hours, work hours, equipment rentals, and other costs.
			</p>
		</div>
		<div class="row row-padded margin-15-top">
			<div class="col-md-3">
				<p class="margin-25-top">
					<h4>
						<strong>Timesheets:</strong> <span class="label label-success">{{ totalTimesheets }}</span>
					</h4>
				</p>				
			</div>
			<div class="col-md-3">
				<p class="margin-25-top">
					<h4>
						<strong>Work Hours:</strong> <span class="label label-success">{{ totalWorkHours }}</span>
					</h4>
				</p>				
			</div>
			<div class="col-md-3">
				<p class="margin-25-top">
					<h4>
						<strong>Travel Hours:</strong> <span class="label label-success">{{ totalTravelHours }}</span>
					</h4>
				</p>				
			</div>
			<div class="col-md-3">
				<p class="margin-25-top">
					<h4>
						<strong>Travel Distance:</strong> <span class="label label-success">{{ totalTravelDistance }} km</span>
					</h4>
				</p>				
			</div>			
		</div>


		<!-- Tool navigation -->
		<div class="row row-padded margin-25-top">
			<button @click="timesheetFormModal" class="btn btn-default">
				<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add Timesheet
			</button>	
		</div>

		<!-- Show a pill for each timesheet (if any present)-->
		<div v-if="searchResults.models.length > 0">
			<!-- Row for pill -->
			<div class="row row-padded margin-35-top">
				<!-- Iterate through timesheets and create a pill for each -->
				<timesheet-pill
					v-for="timesheet in searchResults.models"
					:timesheet="timesheet"
				>					
				</timesheet-pill>
			</div>

		</div>
		<!-- Show alert if no timesheets -->
		<div v-else>
			<div class="row row-padded margin-35-top">
				<div class="alert alert-warning text-center">
					<big><strong>Heads up!</strong> You havn't added any timesheets to this project yet</big>
				</div>				
			</div>			
		</div><!-- / Show alert if no timesheets -->

		<!-- Modal to hold new timesheet form -->
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
		</modal><!-- / Modal to hold new timesheet form -->

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
				return this.stepAndDisectTimesheets('work_jobs', 'hours_worked');
			},

			totalTravelHours(){
				return this.stepAndDisectTimesheets('travel_jobs', 'travel_time');
			},

			totalTravelDistance(){
				return this.stepAndDisectTimesheets('travel_jobs', 'travel_distance');
			}
		},

		methods: {
			timesheetFormModal(){
				this.currentModal = 'Timesheet';
				this.modalActive = true;
			},

			/* Iterates through each of the users timesheets. On each timesheet, an array of foreign relationship assets is
			 * iterated through and the supplied field is sumed up. The final total is returned
			 * @param assetToIterate - the foreign relationship field
			 * @param fieldToAddUp - the field on the foreign relationship to add up 
			*/
			stepAndDisectTimesheets(assetToIterate, fieldToAddUp){
				var total = parseInt(0);
				// Iterate through each timesheet
				this.searchResults.models.forEach(function(timesheet){
					if(timesheet[assetToIterate].length > 0){
						// Iterate through each travel job in timesheet
						timesheet[assetToIterate].forEach(function(current){
							// Update total
							total += parseFloat(current[fieldToAddUp]);
						})
					}
				});

				return total.toFixed(2);				
			}
		},

		created(){
			// Retrieve model through API access
			this.getAndSetModels();

			// When the form component alerts this parent of a successful create
			this.$router.app.$on('timesheet-created', model => {
				model.work_jobs = [];
				model.travel_jobs = [];
				model.equipment_rentals = [];
				model.other_costs = [];
				this.searchResults.models.unshift(model);	
				this.modalActive = false;						
			});	


			this.$router.app.$on('timesheet-deleted', model => {
				// Cache context
				var context = this;				
				console.log(model);
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.id){						
						var index = context.searchResults.models.indexOf(timesheet); 
						context.searchResults.models.splice(index, 1);

						context.currentModal = '';
						context.modalActive = false;
					}
				});										
			});

			this.$router.app.$on('work-job-created', model => {
				// Cache context
				var context = this;
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){					
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
				});											
			});	

			this.$router.app.$on('travel-job-created', model => {
				// Cache context
				var context = this;
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){				
						// Flag which indicates whether the travel job has been added to cache
						var updated = false;						
						// Iterate through travel jobs to determine if a job should be updated or a new 
						// job should be pushed to the collection
						timesheet.travel_jobs.forEach(function(travelJob){
							// Replace existing updated travel job
							if(travelJob.id == model.id){
								// Update travel job fields
								travelJob.travel_distance = model.travel_distance;
								travelJob.travel_time = model.travel_time;
								travelJob.comment = model.comment
								// Update flag
								updated = true;
							}
						});
						// Add a new travel job
						if(!updated){
							timesheet.travel_jobs.push(model);
						}	
					}
				});											
			});	

			this.$router.app.$on('equipment-rental-created', model => {
				// Cache context
				var context = this;
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
						// Flag which indicates whether the equipment rental has been added to cache
						var updated = false;						
						// Iterate through equipment rentals to determine if a rental should be updated or a new 
						// job should be pushed to the collection
						timesheet.equipment_rentals.forEach(function(equipmentRental){
							// Replace existing updated equipment rental
							if(equipmentRental.id == model.id){
								// Update equipment rental fields
								equipmentRental.equipment_type = model.equipment_type;
								equipmentRental.rental_fee = model.rental_fee;
								equipmentRental.comment = model.comment
								// Update flag
								updated = true;
							}
						});
						// Add a new equipment rental
						if(!updated){
							timesheet.equipment_rentals.push(model);
						}	
					}
				});	
			});				

			this.$router.app.$on('other-cost-created', model => {
				// Cache context
				var context = this;
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){				
						// Flag which indicates whether the other cost has been added to cache
						var updated = false;						
						// Iterate through other costs to determine if a cost should be updated or a new 
						// job should be pushed to the collection
						timesheet.other_costs.forEach(function(otherCost){
							// Replace existing updated other cost
							if(otherCost.id == model.id){
								// Update other cost fields
								otherCost.cost_name = model.cost_name;
								otherCost.cost = model.cost;
								otherCost.comment = model.comment
								// Update flag
								updated = true;
							}
						});
						// Add a new other cost
						if(!updated){
							timesheet.other_costs.push(model);
						}	
					}
				});											
			});

			// When the form component alerts this parent of a successful create
			// Updates work jobs, travel jobs, equipment rentals, and other costs from a specific timesheet
			this.$router.app.$on('work-job-deleted', model => {
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
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
				});										
			});

			// When the form component alerts this parent of a successful create
			// Updates work jobs, travel jobs, equipment rentals, and other costs from a specific timesheet
			this.$router.app.$on('travel-job-deleted', model => {
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
						// Flag which indicates whether the workjob has been added to cache
						var updated = false;						
						// Iterate through work jobs to determine if a job should be updated or a new 
						// job should be pushed to the collection
						timesheet.travel_jobs.forEach(function(travelJob){
							// Replace existing updated travel job
							if(travelJob.id == model.id){
								var index = timesheet.travel_jobs.indexOf(travelJob); 
								timesheet.travel_jobs.splice(index, 1);
							}
						});
					}
				});										
			});

			// When the form component alerts this parent of a successful create
			// Updates work jobs, travel jobs, equipment rentals, and other costs from a specific timesheet
			this.$router.app.$on('equipment-rental-deleted', model => {
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
						// Flag which indicates whether the workjob has been added to cache
						var updated = false;						
						// Iterate through work jobs to determine if a job should be updated or a new 
						// job should be pushed to the collection
						timesheet.equipment_rentals.forEach(function(equipmentRental){
							// Replace existing updated equipment rental
							if(equipmentRental.id == model.id){
								var index = timesheet.equipment_rentals.indexOf(equipmentRental); 
								timesheet.equipment_rentals.splice(index, 1);
							}
						});
					}
				});										
			});

			// When the form component alerts this parent of a successful create
			// Updates work jobs, travel jobs, equipment rentals, and other costs from a specific timesheet
			this.$router.app.$on('other-cost-deleted', model => {
				// Iterate through all cached timesheets and execute 
				this.searchResults.models.forEach(function(timesheet){
					// When the timesheet id matches the models id
					if(timesheet.id == model.timesheet_id){
						// Flag which indicates whether the workjob has been added to cache
						var updated = false;						
						// Iterate through work jobs to determine if a job should be updated or a new 
						// job should be pushed to the collection
							timesheet.other_costs.forEach(function(otherCost){
								// Replace existing updated other cost
								if(otherCost.id == model.id){
									var index = timesheet.other_costs.indexOf(otherCost); 
									timesheet.other_costs.splice(index, 1);
								}
							})
					}
				});										
			});							

		}

	}
	
</script>