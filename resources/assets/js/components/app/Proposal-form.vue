<template>
	<div class="well bs-component margin-25-top">
		<form class="form-horizontal">
			<fieldset>
				<legend>
					{{ form.title }}
					<slot name="close"></slot>
				</legend>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.work_type.err}">
							<div class="col-lg-10">
								<label class="control-label">Work Type</label>
								<select v-model="form.fields.work_type.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
			                    	<option value="HRIA">HRIA</option>
			                        <option value="Archaeology">Archaeology</option>
			                        <option value="Palaeontology">Palaeontology</option>
			                    </select>
			                    <span class="text-danger" v-if="form.fields.work_type.err">{{ form.fields.work_type.err }}</span>
							</div>
						</div>					
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.plans.err}">
							<div class="col-lg-10">
								<label class="control-label">Project Plans</label>
								<textarea v-model="form.fields.plans.val" class="form-control margin-10-top" rows="3" placeholder="Project plans"></textarea>
			                    <span class="text-danger" v-if="form.fields.plans.err">{{ form.fields.plans.err }}</span>
							</div>
						</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.work_overview.err}">
							<div class="col-lg-10">
								<label class="control-label">Work Overview</label>
								<textarea v-model="form.fields.work_overview.val" class="form-control margin-10-top" rows="3" placeholder="Overview of work"></textarea>
			                    <span class="text-danger" v-if="form.fields.work_overview.err">{{ form.fields.work_overview.err }}</span>
							</div>
						</div>						
					</div>
				</div>

				<div class="row">			
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.estimate.err}">
		                    <div class="col-lg-10">
		                    	<label class="control-label">Estimate</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="form.fields.estimate.val" type="text" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="form.fields.estimate.err">{{ form.fields.estimate.err }}</span>
		                    </div>
	                  	</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.response_by.err}">
		                    <div class="col-lg-10">
		                    	<label class="control-label">Response By</label>
		                    	<input v-model="form.fields.response_by.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.response_by.err">{{ form.fields.response_by.err }}</span>
		                    </div>
	                  	</div>					
					</div>				
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group" v-bind:class="{'has-error': form.fields.approval_date.err}">
		                    <div class="col-lg-10">
		                    	<label class="control-label">Approval Date</label>
		                    	<input v-model="form.fields.approval_date.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="form.fields.approval_date.err">{{ form.fields.approval_date.err }}</span>
		                    </div>
	                  	</div>					
					</div>				
				</div>												
			</fieldset>
		</form>
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
	</div>	
</template>

<script>
	let hub_controller = require('./mixins/hub-controller.js');

	export default{
		props: ['proposal', 'project_id'],

		mixins: [hub_controller],

		data(){
			return{
				form: {
					model: 'Proposal',
					state: 'create-child',
					title: 'Create Prposal',
					button: 'Save',
					action: '/app/proposals/create',
					createAction: '/app/proposals/create',
					updateAction: '/app/proposals/update',
					isLoading: false,					
					successMsg: 'Proposal has been saved to project',
					fields: {
						id: {val: '', err: false, dflt: ''},
						project_id: {val: this.project_id, err: false, dflt: ''},
						plans: {val: '', err: false, dflt: ''},
						work_type: {val: '', err: false, dflt: ''},
						work_overview: {val: '', err: false, dflt: ''},
						response_by: {val: '', err: false, dflt: ''},
						estimate: {val: '0.00', err: false, dflt: '0.00'},
						approval_date: {val: '', err: false, dflt: ''}		
					}
				}				
			}
		},

		methods: {
			sendForm(){
				this.createOrUpdate();
			}
		},

		mounted(){
			if(this.proposal != undefined){
				// Set form up in edit state
				this.formEditState();
				// Populate form
				for(var key in this.form.fields){
					this.form.fields[key].val = this.proposal[key];
				}
			}
		}
	}
</script>