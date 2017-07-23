<template>
	
<!-- Component container -->
<div>
	<!-- Loader - shows if data is fetching -->
	<div v-if="formIsLoading" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<!-- Form wrapper 'well' -->
	<div v-if="!formIsLoading" class="col-md-12 well bs-component margin-10-top">
		<!-- Travel job form -->
		<form @submit.prevent class="form-horizontal">
			<fieldset>
				<legend>
					<div class="row">
						<div class="col-md-8">
							<h3 class="pull-left" style="margin-top:6px;">{{ form.title }}</h3>
						</div>
						<div class="col-md-4">
							<slot name="close-form"></slot>
						</div>
					</div>
				</legend>

				<div class="row margin-15-top">					
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.travel_distance.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Travel Distance</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">KMs</span>
		                    		<input v-model="form.fields.travel_distance.val" type="number" min="0" max="1000" step="1" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.travel_distance.err">{{ form.fields.travel_distance.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.travel_time.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Travel Time</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">Hrs.</span>
		                    		<input v-model="form.fields.travel_time.val" type="number" min="0" max="20" step="0.1" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.travel_time.err">{{ form.fields.travel_time.err }}</span>
		                    </div>
	                  	</div>					
					</div>															
				</div>

				<div class="row margin-15-top">
					<div class="col-md-12">
						<div class="form-group" :class="{'has-error': form.fields.comment.err}">
							<div class="col-md-12">
								<label class="control-label">Comments</label>
								<textarea v-model="form.fields.comment.val" class="form-control margin-10-top" rows="3" placeholder="Any additional comments"></textarea>
			                    <span class="text-danger" v-if="form.fields.comment.err">{{ form.fields.comment.err }}</span>
							</div>
						</div>						
					</div>
				</div>				
				
			</fieldset>
			<!-- Button -->
			<fieldset>
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button @click="sendForm" class="btn btn-primary btn-block margin-45-top">
								<span v-if="!form.isLoading">{{ form.button }}</span>
								<span v-if="form.isLoading">
									<div class="center-loader"></div>
								</span>
							</button>												
						</div>					
					</div>
				</div>			
			</fieldset>	
			<fieldset v-if="travel_job_id">
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button @click="deleteTravelJob" class="btn btn-danger btn-block margin-25-top">
								<span v-if="!isDeleting">Remove</span>
								<span v-if="isDeleting">
									<div class="loader-center"></div>
								</span>
							</button>												
						</div>					
					</div>
				</div>			
			</fieldset>					
		</form>
	</div><!-- / Form 'well' wrapper -->
</div><!--/ Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		props: ['travel_job_id', 'travel_job', 'timesheet_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				urlToDelete: '/api/travel-jobs/delete',
				isDeleting: false,				
				form: {
					model: 'TravelJob',
					state: 'create',
					title: 'Add Travel Hours',
					button: 'Add',
					action: '/api/travel-jobs/create',
					createAction: '/api/travel-jobs/create',
					updateAction: '/api/travel-jobs/update',
					createEvent: 'travel-job-created',
					updateEvent: 'travel-job-created',	
					deleteEvent: 'travel-job-deleted',						
					isLoading: false,					
					successMsg: 'Travel hours added',
					fields: {
						id: {val: '', err: false, dflt: ''},
						timesheet_id: {val: this.timesheet_id, err: false, dflt: ''},
						travel_distance: {val: '0', err: false, dflt: '0'},	
						travel_time: {val: '0', err: false, dflt: '0'},
						comment: {val: '', err: false, dflt: ''}
					}
				}				
			}
		},

		methods:{
			// Submits the form to server via API access
			sendForm(){
				this.createOrUpdate();
			},

			// Submits a delete to server via mixin
			deleteTravelJob(){
				this.deleteChild();
			}			
		},

		created(){
			// If an id is present then set up the form for edit
			if(this.travel_job_id){
				// Show form loader
				this.formIsLoading = true;
				// Populate form
				this.populateFormFromModel(this.travel_job);
				// Adjust form state
				this.formEditState('edit');
				// Hide form loader
				this.formIsLoading = false;						
			}

		}
		
	}

</script>