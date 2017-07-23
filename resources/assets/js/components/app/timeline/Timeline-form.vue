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
	<div v-if="!formIsLoading" class="col-md-12 well bs-component margin-25-top">
		<!-- Proposal form -->
		<form @submit.prevent class="form-horizontal">
			<fieldset>
				<legend>
					Permit Details
					<!-- Close slot to change sub-tab back -->
					<button slot="close" @click="$router.go(-1)" class="pull-right btn btn-danger">&times;</button>
				</legend>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.permit_application_date.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Permit Application Date</label>
		                    	<input v-model="form.fields.permit_application_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.permit_application_date.err">{{ form.fields.permit_application_date.err }}</span>
		                    </div>
	                  	</div>					
					</div>						
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.permit_recieved_date.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Permit Recieved Date</label>
		                    	<input v-model="form.fields.permit_recieved_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.permit_recieved_date.err">{{ form.fields.permit_application_date.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.permit_number.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Permit Number</label>
		                    	<input v-model="form.fields.permit_number.val" type="text" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.permit_number.err">{{ form.fields.permit_number.err }}</span>
		                    </div>
	                  	</div>					
					</div>
				</div>
			</fieldset>
	
	
			<fieldset class="margin-25-top">
				<legend>Site Number Details</legend>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.site_number_application_date.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Site Number Application Date</label>
		                    	<input v-model="form.fields.site_number_application_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.site_number_application_date.err">{{ form.fields.site_number_application_date.err }}</span>
		                    </div>
	                  	</div>					
					</div>						
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.site_number_recieved_date.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Site Number Recieved Date</label>
		                    	<input v-model="form.fields.site_number_recieved_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.site_number_recieved_date.err">{{ form.fields.site_number_recieved_date.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.site_number.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Site Number</label>
		                    	<input v-model="form.fields.site_number.val" type="text" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.site_number.err">{{ form.fields.site_number.err }}</span>
		                    </div>
	                  	</div>					
					</div>
				</div>
			</fieldset>

			<fieldset class="margin-25-top">

				<legend>Completion Targets</legend>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.completion_target.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Completion Target</label>
		                    	<input v-model="form.fields.completion_target.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.completion_target.err">{{ form.fields.completion_target.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.field_completion_target.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Fieldwork Completion Target</label>
		                    	<input v-model="form.fields.field_completion_target.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.field_completion_target.err">{{ form.fields.field_completion_target.err }}</span>
		                    </div>
	                  	</div>					
					</div>	
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.report_completion_target.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Report Completion Target</label>
		                    	<input v-model="form.fields.report_completion_target.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.report_completion_target.err">{{ form.fields.report_completion_target.err }}</span>
		                    </div>
	                  	</div>					
					</div>													
				</div>

			</fieldset>

			<fieldset class="margin-25-top">
				<legend>Project Milestones</legend>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.fieldwork_scheduled.err}">
							<div class="col-md-12">
								<label class="control-label">Fieldwork Scheduled</label>
								<select v-model="form.fields.fieldwork_scheduled.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.fieldwork_scheduled.err" class="text-danger" >{{ form.fields.fieldwork_scheduled.err }}</span>
							</div>
						</div>						
					</div>
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.artifact_analysis.err}">
							<div class="col-md-12">
								<label class="control-label">Artifact Analysis Complete</label>
								<select v-model="form.fields.artifact_analysis.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.artifact_analysis.err" class="text-danger" >{{ form.fields.artifact_analysis.err }}</span>
							</div>
						</div>						
					</div>	
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.mapping.err}">
							<div class="col-md-12">
								<label class="control-label">Mapping Complete</label>
								<select v-model="form.fields.mapping.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.mapping.err" class="text-danger" >{{ form.fields.mapping.err }}</span>
							</div>
						</div>						
					</div>													
				</div>
			</fieldset>


			<fieldset class="margin-25-top">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.writing.err}">
							<div class="col-md-12">
								<label class="control-label">Writing Complete</label>
								<select v-model="form.fields.writing.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.writing.err" class="text-danger" >{{ form.fields.writing.err }}</span>
							</div>
						</div>						
					</div>
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.draft_submitted.err}">
							<div class="col-md-12">
								<label class="control-label">Draft Submitted</label>
								<select v-model="form.fields.draft_submitted.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.draft_submitted.err" class="text-danger" >{{ form.fields.draft_submitted.err }}</span>
							</div>
						</div>						
					</div>	
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.draft_accepted.err}">
							<div class="col-md-12">
								<label class="control-label">Draft Accepted</label>
								<select v-model="form.fields.draft_accepted.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.draft_accepted.err" class="text-danger" >{{ form.fields.draft_accepted.err }}</span>
							</div>
						</div>						
					</div>													
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group" :class="{'has-error': form.fields.final_approval.err}">
							<div class="col-md-12">
								<label class="control-label">Final Approval</label>
								<select v-model="form.fields.final_approval.val" class="form-control margin-10-top">
			                    	<option value="0">No</option>
			                        <option value="1">Yes</option>
			                    </select>
			                    <span v-if="form.fields.final_approval.err" class="text-danger" >{{ form.fields.final_approval.err }}</span>
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
		</form>
	</div><!-- / Form 'well' wrapper -->
</div><!--/ Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		props: ['timeline', 'project_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				form: {
					model: 'Timeline',
					state: 'create',
					title: 'Add Timeline',
					button: 'Save',
					action: '/api/timelines/create',
					createAction: '/api/timelines/create',
					updateAction: '/api/timelines/update',
					createEvent: 'timeline-created',
					updateEvent: 'timeline-updated',				
					isLoading: false,					
					successMsg: 'Timeline has been saved to project',
					fields: {
						id: {val: '', err: false, dflt: ''},
						project_id: {val: this.project_id, err: false, dflt: ''},
						permit_application_date: {val: '', err: false, dflt: ''},
						permit_recieved_date: {val: '', err: false, dflt: ''},
						permit_number: {val: '', err: false, dflt: ''},
						site_number_application_date: {val: '', err: false, dflt: ''},
						site_number_recieved_date: {val: '', err: false, dflt: ''},
						site_number: {val: '', err: false, dflt: ''},
						completion_target: {val: '', err: false, dflt: ''},		
						field_completion_target: {val: '', err: false, dflt: ''},
						report_completion_target: {val: '', err: false, dflt: ''},
						fieldwork_scheduled: {val: 0, err: false, dflt: 0},
						artifact_analysis: {val: 0, err: false, dflt: 0},
						mapping: {val: 0, err: false, dflt: 0},
						writing: {val: 0, err: false, dflt: 0},
						draft_submitted: {val: 0, err: false, dflt: 0},
						draft_accepted: {val: 0, err: false, dflt: 0},
						final_approval: {val: 0, err: false, dflt: 0}
					}
				}				
			}
		},

		watch:{
			// Wait for the proposal prop to be populated and then turn off loading
			timeline(){
				this.formIsLoading = false;
			}
		},

		methods: {
			sendForm(){		
				this.form.fields.project_id.val = this.project_id;
				this.createOrUpdate();
			}
		},

		created(){
			console.log('Form-mounted');

			if(!this.timeline){
				this.isLoading = true;
			}
						
			if(this.timeline){
				// Populate form
				this.populateFormFromModel(this.timeline);
				// Set the form state
				this.formEditState('edit-child');
			}
		}
	}
</script>