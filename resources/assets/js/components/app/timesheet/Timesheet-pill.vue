<template>

<!-- Component container -->	
<div>
	
	<!-- Pill column -->
	<div class="col-md-4">
		<div class="panel panel-white post panel-shadow">
			<div class="row row-padded">
		    	<dropdown v-bind:title="'Actions'" class="pull-right">
					<li>
						<a @click="addWorkHours(timesheet.id)">Add Work Hours</a>
					</li>		    	
					<li>
						<a @click="addTravel(timesheet.id)">Add Travel</a>
					</li>
					<li>
						<a @click="addEquipmentRental(timesheet.id)">Add Equipment Rental</a>
					</li>	
					<li>
						<a @click="addOtherCost(timesheet.id)">Add Other Cost</a>
					</li>																				
		    	</dropdown>						
			</div>
		
			<!-- Timesheet basics -->
			<div class="panel-body">
				<ul class="list-group margin-10-top">				
					<li class="list-group-item">						
						<strong>Project Identifier</strong><br>
						{{ timesheet.project_id }}
					</li>				
					<li class="list-group-item">						
						<strong>Date</strong><br>
						{{ timesheet.date }}
					</li>						
					<li class="list-group-item">						
						<strong>Per Diem</strong><br>
						${{ timesheet.per_diem }}
					</li>
					<li class="list-group-item">
						<strong>Comment</strong><br>
						{{ timesheet.comment }}
					</li>																										
				</ul>												
			</div>
		</div>
	</div><!-- / Pill column -->

	<!-- Modal to hold the timesheet option forms -->
	<modal 
		:modalActive="modalActive" 
		@modal-close="modalActive = false"
	>
		<p slot="body">
			<work-job-form
				v-if="formToShow == 'Work-job'"
				:timesheet_id="timesheet.id"
			>
			</work-job-form>
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
	let workjob_form = require('./../timesheet/Work-job-form.vue');

	export default{
		components: {
			'dropdown': dropdown,
			'modal': modal,
			'work-job-form': workjob_form
		},

		props: ['timesheet'],

		data(){
			return{
				// Toggles which form to show in the modal
				formToShow: '',
				// Show modal or not
				modalActive: false				
			}
		},

		methods:{
			addTravel(id){
				this.formToShow = 'Travel-time';
				this.modalActive = true;
			},

			addWorkHours(id){
				this.formToShow = 'Work-job';
				this.modalActive = true;

			},

			addEquipmentRental(id){
				this.formToShow = 'Equipment-rental';
				this.modalActive = true;
			},

			addOtherCost(id){
				this.formToShow = 'Other-cost';
				this.modalActive = true;
			}
		}
	}

</script>