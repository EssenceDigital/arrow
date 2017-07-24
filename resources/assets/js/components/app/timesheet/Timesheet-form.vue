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
	<div v-if="!formIsLoading" class="col-md-12 well bs-component margin-45-top">
		<!-- Timesheet form -->
		<form @submit.prevent class="form-horizontal">
			<fieldset>
				<legend>
					{{ form.title }}
				</legend>

				<div class="row margin-15-top">					
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.date.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Date</label>
		                    	<input v-model="form.fields.date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.date.err">{{ form.fields.date.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.per_diem.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Per Diem</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="form.fields.per_diem.val" type="text" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.per_diem.err">{{ form.fields.per_diem.err }}</span>
		                    </div>
	                  	</div>					
					</div>										
				</div>

				<div class="row margin-15-top">
					<div class="col-md-12">
						<div class="form-group" :class="{'has-error': form.fields.comment.err}">
							<div class="col-md-12">
								<label class="control-label">Comment</label>
								<textarea v-model="form.fields.comment.val" class="form-control margin-10-top" rows="3" placeholder="Overview of work"></textarea>
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
			<!-- Delete Button -->
			<fieldset v-if="timesheet_id">
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button @click="deleteTimesheet" class="btn btn-danger btn-block margin-25-top">
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
	let modal = require('./../_ui/Modal.vue');

	export default{
		components: {
			'modal': modal
		},

		props: ['timesheet_id', 'timesheet', 'project_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				urlToDelete: '/api/timesheets/delete',
				isDeleting: false,					
				form: {
					model: 'Timesheet',
					state: 'create',
					title: 'Add Tmesheet',
					button: 'Add',
					action: '/api/timesheets/create',
					createAction: '/api/timesheets/create',
					updateAction: '/api/timesheets/update',
					createEvent: 'timesheet-created',
					updateEvent: 'timesheet-created',
					deleteEvent: 'timesheet-deleted',
					isLoading: false,					
					successMsg: 'Your timesheet has been added to the project',
					fields: {
						id: {val: '', err: false, dflt: ''},
						project_id: {val: this.project_id, err: false, dflt: ''},
						date: {val: '', err: false, dflt: ''},	
						per_diem: {val: '0.00', err: false, dflt: '0.00'},
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

			deleteTimesheet(){
				this.deleteChild(this.timesheet_id)
			}
		},

		created(){

			// If an id is present then set up the form for edit
			if(this.timesheet_id){
				// Show form loader
				this.formIsLoading = true;
				// Populate form
				this.populateFormFromModel(this.timesheet);
				// Adjust form state
				this.formEditState('edit');
				// Hide form loader
				this.formIsLoading = false;									
			}

		}
	}
</script>