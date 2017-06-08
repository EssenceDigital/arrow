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
					{{ form.title }}
					<!-- Close slot to change sub-tab back -->
					<button slot="close" @click="$router.go(-1)" class="pull-right btn btn-danger">&times;</button>
				</legend>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.permit_application_date.err}">
		                    <div class="col-lg-10">
		                    	<label class="control-label">Response By</label>
		                    	<input v-model="form.form.permit_application_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.form.permit_application_date.err">{{ form.fields.form.permit_application_date.err }}</span>
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
					state: 'create-child',
					title: 'Add Timeline',
					button: 'Save',
					action: '/api/timelines/create',
					createAction: '/api/timelines/create',
					updateAction: '/api/timelines/update',
					isLoading: false,					
					successMsg: 'Timeline has been saved to project',
					fields: {
						id: {val: '', err: false, dflt: ''},
						project_id: {val: this.project_id, err: false, dflt: ''},
						permit_application_date: {val: '', err: false, dflt: ''},
						permit_recieved: {val: '', err: false, dflt: ''},
						permit_recieved_date: {val: '', err: false, dflt: ''},
						permit_number: {val: '', err: false, dflt: ''},
						site_number_applied_for: {val: '', err: false, dflt: ''},
						site_number: {val: '', err: false, dflt: ''},
						completion_target: {val: '', err: false, dflt: ''},		
						field_completion_target: {val: '', err: false, dflt: ''},
						report_completion_target: {val: '', err: false, dflt: ''},
						fieldwork_scheduled: {val: '', err: false, dflt: ''},
						artifact_analysis: {val: '', err: false, dflt: ''},
						mapping: {val: '', err: false, dflt: ''},
						writing: {val: '', err: false, dflt: ''},
						draft_submitted: {val: '', err: false, dflt: ''},
						draft_accepted: {val: '', err: false, dflt: ''},
						draft_accepted_date: {val: '', err: false, dflt: ''},
						final_approval: {val: '', err: false, dflt: ''}
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