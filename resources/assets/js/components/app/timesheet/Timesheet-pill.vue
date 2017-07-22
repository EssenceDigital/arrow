<template>

<!-- Component container -->	
<div>
	
	<!-- Pill column -->
	<div class="col-md-10 col-centered">
		<div class="panel panel-white post panel-shadow">
			<div class="row row-padded">
				<div class="col-md-6 col-centered">
					<div class="btn-toolbar">						
						<a @click="addWorkHours(timesheet.id)" class="btn btn-info btn-sm margin-10-top">
							<span class="glyphicon glyphicon-hourglass"></span>&nbsp;Add Hours
						</a>
						<a @click="addTravel(timesheet.id)" class="btn btn-info btn-sm margin-10-top">
							<span class="glyphicon glyphicon-road"></span>&nbsp;Add Travel
						</a>
						<a @click="addEquipmentRental(timesheet.id)" class="btn btn-info btn-sm margin-10-top">
							<span class="glyphicon glyphicon-tags"></span>&nbsp;Add Equipment
						</a>
						<a @click="addOtherCost(timesheet.id)" class="btn btn-info btn-sm margin-10-top">
							<span class="glyphicon glyphicon-usd"></span>&nbsp;Add Other
						</a>			
					</div>					
				</div>
								
			</div>
		
			<!-- Timesheet panel -->
			<div class="panel-body">
				<!-- The timesheet table tab -->
				<ul 
					v-if="tabToShow =='List'"
					class="list-group margin-10-top"
				>				
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-6">
								<strong>Date</strong><br>
								{{ timesheet.date }}								
							</div>
							<div class="col-md-6">
								<strong>Per Diem</strong><br>
								${{ timesheet.per_diem }}								
							</div>							
						</div>
						<div class="row margin-20-top">
							<div class="col-md-12">
								<strong>Comment</strong><br>
								{{ timesheet.comment }}								
							</div>
						</div>						
					</li>

					<!-- Travel hours heading -->				
					<li 
						v-if="timesheet.travel_jobs.length > 0"
						class="list-group-item"
					>
						<h4>
							<span class="label label-primary">Travel Hours</span>
						</h4>
					</li>
					<!-- Travel hours section -->	
					<li 
						v-if="timesheet.travel_jobs.length > 0"
						v-for="travelJob in timesheet.travel_jobs"
						class="list-group-item"
					>
						<div class="row">
							<div class="col-md-5">
								<strong>Travel Distance</strong><br>
								{{ travelJob.travel_distance }} km							
							</div>
							<div class="col-md-5">
								<strong>Travel Hours</strong><br>
								{{ parseFloat(travelJob.travel_time) }}									
							</div>
							<div class="col-md-2">
						    	<div class="pull-right">
						    		<span @click="editTravel(travelJob)" class="glyphicon glyphicon-cog hover"></span>
						    	</div>								
							</div>							
						</div>
						<div 
							v-if="travelJob.comment"
							class="row margin-20-top"
						>
							<div class="col-md-12">
								<strong>Comment</strong><br>
								{{ travelJob.comment }}								
							</div>
						</div>
					</li><!-- / Travel hours section -->	

					<!-- Work hours heading -->				
					<li 
						v-if="timesheet.work_jobs.length > 0"
						class="list-group-item"
					>
						<h4>
							<span class="label label-primary">Work Hours</span>
						</h4>
					</li>
					<!-- Work hours section -->	
					<li 
						v-if="timesheet.work_jobs.length > 0"
						v-for="workjob in timesheet.work_jobs"
						class="list-group-item"
					>
						<div class="row">
							<div class="col-md-5">
								<strong>Job Type</strong><br>
								{{ workjob.job_type }}								
							</div>
							<div class="col-md-5">
								<strong>Hours</strong><br>
								{{ parseFloat(workjob.hours_worked) }}									
							</div>
							<div class="col-md-2">
						    	<div class="pull-right">
						    		<span @click="editWorkHours(workjob)" class="glyphicon glyphicon-cog hover"></span>
						    	</div>								
							</div>							
						</div>
						<div 
							v-if="workjob.comment"
							class="row margin-20-top"
						>
							<div class="col-md-12">
								<strong>Comment</strong><br>
								{{ workjob.comment }}								
							</div>
						</div>
					</li><!-- / Work hours section -->																											
				</ul><!-- / The timesheet table tab -->	

				<!-- Work job form tab -->
				<work-job-form
					v-if="tabToShow == 'Work-job'"
					:timesheet_id="timesheet.id"
					:work_job_id="currentWorkJob.id"
					:work_job="currentWorkJob"
				>
					<button 
						slot="close-form"
						@click="tabToShow = 'List'" 
						class="pull-right btn btn-danger"
					>
						&times;
					</button>
				</work-job-form>

				<!-- Travel job form tab -->
				<travel-job-form
					v-if="tabToShow == 'Travel-job'"
					:timesheet_id="timesheet.id"
					:travel_job_id="currentTravelJob.id"
					:travel_job="currentTravelJob"
				>
					<button 
						slot="close-form"
						@click="tabToShow = 'List'" 
						class="pull-right btn btn-danger"
					>
						&times;
					</button>
				</travel-job-form>	

				<!-- Equipment rental form tab -->
				<equipment-rental-form
					v-if="tabToShow == 'Equipment-rental'"
					:timesheet_id="timesheet.id"
				>
					<button 
						slot="close-form"
						@click="tabToShow = 'List'" 
						class="pull-right btn btn-danger"
					>
						&times;
					</button>
				</equipment-rental-form>

				<!-- Other cost form tab -->
				<other-cost-form
					v-if="tabToShow == 'Other-cost'"
					:timesheet_id="timesheet.id"
				>
					<button 
						slot="close-form"
						@click="tabToShow = 'List'" 
						class="pull-right btn btn-danger"
					>
						&times;
					</button>
				</other-cost-form>																										
			</div><!-- / Timesheet panel -->

		</div>
	</div><!-- / Pill column -->

	<!-- Modal to hold the timesheet option forms -->
	<modal 
		:modalActive="modalActive" 
		@modal-close="modalActive = false"
	>
		<p slot="body">

		</p>
		<div slot="footer">
			<button @click="modalActive = false" class="btn btn-primary margin-45-top">Cancel</button>
		</div>
	</modal><!-- / Modal to hold the timesheet option forms -->

</div><!-- / Component container -->

</template>

<script>
	let dropdown = require('./../_ui/Dropdown.vue');
	let modal = require('./../_ui/Modal.vue');
	let work_job_form = require('./../timesheet/Work-job-form.vue');
	let travel_job_form = require('./../timesheet/Travel-job-form.vue');
	let equipment_rental_form = require('./../timesheet/Equipment-rental-form.vue');
	let other_cost_form = require('./../timesheet/Other-cost-form.vue');

	export default{
		components: {
			'dropdown': dropdown,
			'modal': modal,
			'work-job-form': work_job_form,
			'travel-job-form': travel_job_form,
			'equipment-rental-form': equipment_rental_form,
			'other-cost-form': other_cost_form
		},

		props: ['timesheet'],

		data(){
			return{
				// Toggles which form to show in the modal
				tabToShow: 'List',
				// Show modal or not
				modalActive: false,
				currentWorkJob: '',
				currentTravelJob: ''			
			}
		},

		methods:{
			addTravel(id){
				if(this.timesheet.travel_jobs.length >= 1){
	                 noty({
	                     text: '<h4>Travel hours already on this timesheet!</h4>',
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 2000,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });					
				} else{
					this.currentTravelJob = '';
					this.tabToShow = 'Travel-job';
				}
			},

			editTravel(travelJob){
				this.currentTravelJob = travelJob;
				this.tabToShow = 'Travel-job';
			},

			addWorkHours(id){
				this.currentWorkJob = ''
				this.tabToShow = 'Work-job';

			},

			editWorkHours(workJob){
				this.currentWorkJob = workJob;
				this.tabToShow = 'Work-job';
			},

			addEquipmentRental(id){
				this.tabToShow = 'Equipment-rental';
			},

			addOtherCost(id){
				this.tabToShow = 'Other-cost';
			}
		},

		created(){

			// When the form component alerts this parent of a successful create
			this.$router.app.$on('child-created', model => {
				this.tabToShow = 'List';				
			});	

			// When the form component alerts this parent of a successful create
			this.$router.app.$on('child-deleted', model => {
				this.tabToShow = 'List';	
			});			
		}
	}

</script>