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
							<div class="form-group" :class="{'has-error': form.fields.cost_name.err}">
			                    <div class="col-md-12">
			                    	<label class="control-label">Cost Name</label>
			                    	<input v-model="form.fields.cost_name.val" type="text" class="form-control margin-10-top" placeholder="Name of cost">
			                    	<span class="text-danger" v-if="form.fields.cost_name.err">{{ form.fields.cost_name.err }}</span>
			                    </div>
		                  	</div>					
						</div>
					<div class="col-md-6">
						<div class="form-group" :class="{'has-error': form.fields.cost.err}">
		                    <div class="col-md-12">
		                    	<label class="control-label">Cost</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="form.fields.cost.val" type="text" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.cost.err">{{ form.fields.cost.err }}</span>
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
		</form>
	</div><!-- / Form 'well' wrapper -->
</div><!--/ Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		props: ['other_cost_id', 'other_cost', 'timesheet_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				form: {
					model: 'OtherCost',
					state: 'create',
					title: 'Add Other Cost',
					button: 'Add',
					action: '/api/other-costs/create',
					createAction: '/api/other-costs/create',
					updateAction: '/api/other-costs/update',
					isLoading: false,					
					successMsg: 'Other cost added',
					fields: {
						id: {val: '', err: false, dflt: ''},
						timesheet_id: {val: this.timesheet_id, err: false, dflt: ''},
						cost_name: {val: '', err: false, dflt: ''},	
						cost: {val: '0.00', err: false, dflt: '0.00'},
						comment: {val: '', err: false, dflt: ''}
					}
				}				
			}
		},

		methods:{
			// Submits the form to server via API access
			sendForm(){
				this.createOrUpdate();
			}
		},

		created(){
			// If an id is present then set up the form for edit
			if(this.other_cost_id){
				// Show form loader
				this.formIsLoading = true;
				// Populate form
				this.populateFormFromModel(this.other_cost);
				// Adjust form state
				this.formEditState('edit');
				// Hide form loader
				this.formIsLoading = false;						
			}

		}
		
	}

</script>