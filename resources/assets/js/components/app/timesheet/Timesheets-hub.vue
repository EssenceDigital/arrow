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

		},

		mounted(){
			console.log(this.searchResults.models);
		}


	}
	
</script>