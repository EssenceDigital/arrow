<template>
	
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
			proposal(){
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