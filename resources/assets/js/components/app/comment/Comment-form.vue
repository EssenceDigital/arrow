<template>

	<div>
		<form @submit.prevent class="form-horizontal">
			<fieldset>
				<div class="row">
					<div class="col-md-8 col-centered">
						<div class="form-group" :class="{'has-error': form.fields.comment.err}">
			                <div class="col-md-12">
			                	<label class="control-label">Note</label>
			                    <textarea v-model="form.fields.comment.val" class="form-control margin-10-top" rows="3" placeholder="Your note here"></textarea>
			                    <span v-if="form.fields.comment.err" class="text-danger">{{ form.fields.comment.err }}</span>
			                </div>
			            </div>						
					</div>				
				</div>
			</fieldset>
			<!-- Form button -->	
			<fieldset>
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button v-on:click="sendForm" class="btn btn-primary btn-block margin-45-top">
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
	</div>

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		mixins: [api_access],

		props: ['model', 'urlPortion', 'project_id'],

		data(){
			return {
					form: {
						model: this.model,
						state: 'create',
						title: 'Add Comment',
						button: 'Save',
						action: '/api/' + this.urlPortion + '/add-comment',
						createAction: '/api/' + this.urlPortion + '/add-comment',
						updateAction: '/api/' + this.urlPortion + '/update-comment',
						isLoading: false,					
						successMsg: 'Comment has been saved',
						fields: {
							id: {val: '', err: false, dflt: ''},
							project_id: {val: this.project_id, err: false, dflt: ''},
							user_id: {val: DASHBOARD_USER_ID, err: false, dflt: ''},
							comment: {val: '', err: false, dflt: ''}	
						}
				}
			}			
		},

		methods:{
			// Submits the form to server via mixin
			sendForm(){
				this.createOrUpdate();
			},			
		}
	}

</script>