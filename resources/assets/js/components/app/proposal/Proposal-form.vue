<template>

<!-- Containing div -->
<div class="col-md-12 well bs-component margin-25-top">

	<!-- Proposal form -->
	<form class="form-horizontal"
		@submit.prevent
	>
		<fieldset>
			<legend>
				{{ form.title }}
				<!-- Close slot to change sub-tab back -->
				<button slot="close" @click="$router.go(-1)" class="pull-right btn btn-danger">&times;</button>
			</legend>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group" :class="{'has-error': form.fields.work_type.err}">
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
					<div class="form-group" :class="{'has-error': form.fields.plans.err}">
						<div class="col-lg-10">
							<label class="control-label">Project Plans</label>
							<textarea v-model="form.fields.plans.val" class="form-control margin-10-top" rows="3" placeholder="Project plans"></textarea>
		                    <span class="text-danger" v-if="form.fields.plans.err">{{ form.fields.plans.err }}</span>
						</div>
					</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" :class="{'has-error': form.fields.work_overview.err}">
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
					<div class="form-group" :class="{'has-error': form.fields.estimate.err}">
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
					<div class="form-group" :class="{'has-error': form.fields.response_by.err}">
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
					<div class="form-group" :class="{'has-error': form.fields.approval_date.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Approval Date</label>
	                    	<input v-model="form.fields.approval_date.val" type="date" class="form-control margin-10-top">
	                    	<span class="text-danger" v-if="form.fields.approval_date.err">{{ form.fields.approval_date.err }}</span>
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
</div><!-- / containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		props: ['proposal', 'project_id'],

		mixins: [api_access],

		data(){
			return{
				form: {
					model: 'Proposal',
					state: 'create-child',
					title: 'Add Proposal',
					button: 'Save',
					action: '/api/proposals/create',
					createAction: '/api/proposals/create',
					updateAction: '/api/proposals/update',
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

		created(){
			console.log('Form-mounted');
			if(this.proposal){
				this.populateFormFromModel(this.proposal);
				this.formEditState('edit-child');
			}
		}
	}
</script>