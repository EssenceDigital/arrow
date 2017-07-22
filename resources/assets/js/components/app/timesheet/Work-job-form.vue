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
		<!-- Work job form -->
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
						<div class="form-group" :class="{'has-error': form.fields.job_type.err}">
							<div class="col-md-12">
								<label class="control-label">Job Type</label>
								<select v-model="form.fields.job_type.val" class="form-control margin-10-top">
									<option value="" selected>Select...</option>
									<option value="Fieldwork">Fieldwork</option>
									<option value="Documentation">Documentation</option>
									<option value="Report Writing">Report Writing</option>
			                    </select>
			                    <span v-if="form.fields.job_type.err" class="text-danger" >{{ form.fields.job_type.err }}</span>
							</div>
						</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.hours_worked.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Hours Worked</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">Hrs.</span>
		                    		<input v-model="form.fields.hours_worked.val" type="number" min="0" max="20" step="0.1" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.hours_worked.err">{{ form.fields.hours_worked.err }}</span>
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
			<!-- Button -->
			<fieldset v-if="work_job_id">
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button @click="deleteWorkJob" class="btn btn-danger btn-block margin-25-top">
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

		props: ['work_job_id', 'work_job', 'timesheet_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				urlToDelete: '/api/work-jobs/delete',
				isDeleting: false,					
				form: {
					model: 'WorkJob',
					state: 'create-child',
					title: 'Add Work Hours',
					button: 'Add',
					action: '/api/work-jobs/create',
					createAction: '/api/work-jobs/create',
					updateAction: '/api/work-jobs/update',
					isLoading: false,					
					successMsg: 'Work hours added',
					fields: {
						id: {val: '', err: false, dflt: ''},
						timesheet_id: {val: this.timesheet_id, err: false, dflt: ''},
						job_type: {val: '', err: false, dflt: ''},	
						hours_worked: {val: '0', err: false, dflt: '0'},
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
			deleteWorkJob(){
				this.deleteChild();
			}		
		},

		created(){

			// If an id is present then set up the form for edit
			if(this.work_job_id){
				// Show form loader
				this.formIsLoading = true;
				// Populate form
				this.populateFormFromModel(this.work_job);
				// Adjust form state
				this.formEditState('edit-child');
				// Hide form loader
				this.formIsLoading = false;						
			}

		}
		
	}

</script>