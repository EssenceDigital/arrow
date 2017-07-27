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
		<div class="row row-padded margin-15-bottom">
			<button 
				@click="$router.go(-1)" 
				class="pull-left btn btn-info"
			>
				<span class="glyphicon glyphicon-arrow-left"></span> Go back
			</button>			
		</div>
		<div v-if="!user" class="row row-padded">
			<h2>Project Timesheets <small>(Project {{ this.project_id }})</small></h2>
			<p class="margin-25-top">
				Now showing all of your timesheets for this project.
			</p>
			<p class="margin-25-top text-info">
				<span class="glyphicon glyphicon-question-sign"></span>
				Once you add a timesheet you can then add travel hours, work hours, equipment rentals, and other costs.
			</p>
		</div>

		<div v-if="user" class="row row-padded">
			<h2>{{ user.first }}'s' Timesheets <small>(Project {{ this.project_id }})</small></h2>
			<p class="margin-25-top">
				Below are all of {{ user.first }}'s timesheets for this project.
			</p>
			
		</div>

		<div class="row row-padded margin-15-top">
			<div class="col-md-4">
				<div class="bs-component">
					<ul class="list-group">
						<li class="list-group-item">
						  <strong>Travel Totals</strong>
						</li>
						<li class="list-group-item">
						  <span class="badge">{{ totalTravelDistance }} km</span>
						  Total Distance
						</li>
						<li class="list-group-item">
						  <span class="badge">{{ totalTravelHours }} hrs</span>
						  Total Time
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="bs-component">
					<ul class="list-group">
						<li class="list-group-item">
						  <strong>Hour Totals</strong>
						</li>
						<li class="list-group-item">
						  <span class="badge">{{ totalWorkHours }} hrs</span>
						  Total Hours
						</li>
						<li class="list-group-item">
						  <span class="badge">${{ totalWorkPay }}</span>
						  Net Pay
						</li>
					</ul>
				</div>
			</div>	
			<div class="col-md-4">
				<div class="bs-component">
					<ul class="list-group">
						<li class="list-group-item">
						  <strong>Other Totals</strong>
						</li>
						<li class="list-group-item">
						  <span class="badge">${{ totalEquipmentRentalCost }}</span>
						  Equipment Cost Total
						</li>
						<li class="list-group-item">
						  <span class="badge">${{ totalOtherCosts }}</span>
						  Total Other Costs
						</li>
					</ul>
				</div>
			</div>								
		</div>

		<div class="row row-padded">
			<div class="col-md-12 text-center">
				<div class="bs-component">
					<ul class="list-group">
						<li class="list-group-item">
							<p class="margin-25-top">							
						 		<strong>Invoice Total</strong>
						 	</p>
						 	<p class="margin-10-top">
						 		<span class="label label-success">${{ parseFloat(totalWorkPay) + parseFloat(totalEquipmentRentalCost) + parseFloat(totalOtherCosts) }}</span>
						 	</p>
						 	
						</li>
					</ul>
				</div>
			</div>				
		</div>


		<!--<div class="row row-padded margin-15-top">
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Timesheets:</strong> <span class="label label-success">{{ totalTimesheets }}</span>
					</h4>
				</p>								
			</div>
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Travel Hours:</strong> <span class="label label-success">{{ totalTravelHours }}</span>
					</h4>
				</p>				
			</div>
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Travel Distance:</strong> <span class="label label-success">{{ totalTravelDistance }} km</span>
					</h4>
				</p>				
			</div>						
		</div>

		<div class="row row-padded margin-15-top">
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Work Hours:</strong> <span class="label label-success">{{ totalWorkHours }}</span>
					</h4>
				</p>								
			</div>		
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Net Total:</strong> <span class="label label-success">${{ totalWorkPay }}</span>
					</h4>
				</p>				
			</div>
			<div class="col-md-4">
				<p class="margin-25-top">
					<h4>
						<strong>Per Diem Total:</strong> <span class="label label-success">${{ totalPerDiem }}</span>
					</h4>
				</p>				
			</div>			
		</div>-->




		<!-- Tool navigation -->
		<div v-if="!user" class="row row-padded margin-25-top">
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
					:user="user"
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
			v-if="!user"
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

		props: ['project_id', 'user'],

		mixins: [api_access],

		data(){
			return {
				adminState: false,
				currentModal: '',
				// For the form modal
				modalActive: false,
				// Used by API access
				urlToFetch: '',
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

			totalPerDiem(){
				return this.stepAndDisectTimesheets('', 'per_diem');
			},

			totalWorkHours(){
				return this.stepAndDisectTimesheets('work_jobs', 'hours_worked');
			},

			totalWorkPay(){
				if(this.user){
					var pay = this.totalWorkHours * this.user.hourly_rate_one;
				} else {
					var pay = this.totalWorkHours * DASHBOARD_USER_HOURLY;
				}

				return parseFloat(pay);
			},

			totalTravelHours(){
				return this.stepAndDisectTimesheets('travel_jobs', 'travel_time');
			},

			totalTravelDistance(){
				return this.stepAndDisectTimesheets('travel_jobs', 'travel_distance');
			},

			totalEquipmentRentalCost() {
				return this.stepAndDisectTimesheets('equipment_rentals', 'rental_fee');
			},

			totalOtherCosts(){
				return this.stepAndDisectTimesheets('other_costs', 'cost');
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
					// If the asset field is an array
					if(assetToIterate != ''){
						if(timesheet[assetToIterate].length > 0){
							// Iterate through each travel job in timesheet
							timesheet[assetToIterate].forEach(function(current){
								// Update total
								total += parseFloat(current[fieldToAddUp]);
							})
						}						
					} else {
						// If the asset field is not an array then just do a tally
						total += parseFloat(timesheet[fieldToAddUp]);
					}

				});

				return total.toFixed(2);				
			}
		},

		created(){

			if(this.project_id){

				if(!this.user){
					this.urlToFetch = '/api/dashboard/project-timesheets/'+this.project_id;
				} else {
					this.urlToFetch = '/api/users/'+this.user.id+'/projects/'+this.project_id+'/timesheets';
				}

				// Retrieve model through API access
				this.getAndSetModels();
			}


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