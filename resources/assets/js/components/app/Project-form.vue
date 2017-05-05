<template>

<div class="well bs-component">
	<form class="form-horizontal">
		<fieldset>
			<legend>Start a project</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.province.err}">
						<div class="col-lg-10">
							<label class="control-label">Province</label>
							<select v-model="form.province.val" class="form-control margin-10-top">
								<option value="" selected disabled="">Select...</option>
		                    	<option>Alberta</option>
		                        <option>British Columbia</option>
		                        <option>Saskatchewan</option>
		                    </select>
						</div>
					</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.location.err}">
		                <div class="col-lg-10">
		                	<label class="control-label">Location</label>
		                    <textarea v-model="form.location.val" class="form-control margin-10-top" rows="3" placeholder="Specific location"></textarea>
		                    <span v-if="form.location.err">{{ form.location.msg }}</span>
		                </div>
		            </div>						
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.details.err}">
		                <div class="col-lg-10">
		                	<label class="control-label">Details</label>
		                    <textarea v-model="form.details.val" class="form-control margin-10-top" rows="3" placeholder="Project details"></textarea>
		                    <span v-if="form.details.err">{{ form.details.msg }}</span>
		                </div>
		            </div>						
				</div>				
			</div>
		</fieldset>
		<fieldset class="margin-25-top">
			<legend>Client and contact</legend>
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.client_company_name.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Client company</label>
	                    	<input v-model="form.client_company_name.val" type="text" class="form-control margin-10-top" placeholder="Name of company">
	                    	<span v-if="form.client_company_name.err">{{ form.client_company_name.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.client_contact_name.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Client contact</label>
	                    	<input v-model="form.client_contact_name.val" type="text" class="form-control margin-10-top" placeholder="Name of contact">
	                    	<span v-if="form.client_contact_name.err">{{ form.client_contact_name.msg }}</span>
	                    </div>
                  	</div>					
				</div>				
			</div>
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.client_contact_phone.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Client contact phone</label>
	                    	<input v-model="form.client_contact_phone.val" type="text" class="form-control margin-10-top" placeholder="Contact phone number">
	                    	<span v-if="form.client_contact_phone.err">{{ form.client_contact_phone.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.client_contact_email.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Client contact email</label>
	                    	<input v-model="form.client_contact_email.val" type="text" class="form-control margin-10-top" placeholder="Contact email">
	                    	<span v-if="form.client_contact_email.err">{{ form.client_contact_email.msg }}</span>
	                    </div>
                  	</div>					
				</div>				
			</div>
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.first_contact_by.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">First contact by</label>
	                    	<input v-model="form.first_contact_by.val" type="text" class="form-control margin-10-top" placeholder="First contact by">
	                    	<span v-if="form.first_contact_by.err">{{ form.first_contact_by.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.first_contact_date.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">First contact date</label>
	                    	<input v-model="form.first_contact_date.val" type="date" class="form-control margin-10-top">
	                    	<span v-if="form.first_contact_date.err">{{ form.first_contact_date.msg }}</span>
	                    </div>
                  	</div>					
				</div>				
			</div>
		</fieldset>
		<fieldset class="margin-25-top">
			<legend>Land ownership</legend>
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.land_ownership.err}">
						<div class="col-lg-10">
							<label class="control-label">Land ownership</label>
							<select v-model="form.land_ownership.val" class="form-control margin-10-top">
								<option value="" selected disabled="">Select...</option>
		                    	<option>Crown</option>
		                        <option>Freehold</option>
		                    </select>
						</div>
					</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.land_access_granted.err}">
						<div class="col-lg-10">
							<label class="control-label">Land access granted</label>
							<select v-model="form.land_access_granted.val" class="form-control margin-10-top">
								<option value="0">No</option>
		                    	<option value="1">Yes</option>
		                    </select>
						</div>
					</div>					
				</div>				
			</div>	
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.land_access_granted_by.err}">
						<div class="col-lg-10">
							<label class="control-label">Land access granted by</label>
	                    	<input v-model="form.land_access_granted_by.val" type="text" class="form-control margin-10-top" placeholder="Access granted by">
	                    	<span v-if="form.land_access_granted_by.err">{{ form.land_access_granted_by.msg }}</span>
						</div>
					</div>					
				</div>						
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.land_access_contact.err}">
						<div class="col-lg-10">
							<label class="control-label">Land access contact</label>
	                    	<input v-model="form.land_access_contact.val" type="text" class="form-control margin-10-top" placeholder="Access contact name">
	                    	<span v-if="form.land_access_contact.err">{{ form.land_access_contact.msg }}</span>
						</div>
					</div>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.land_access_phone.err}">
						<div class="col-lg-10">
							<label class="control-label">Land access phone</label>
	                    	<input v-model="form.land_access_phone.val" type="text" class="form-control margin-10-top" placeholder="Access contact phone number">
	                    	<span v-if="form.land_access_phone.err">{{ form.land_access_phone.msg }}</span>
						</div>
					</div>						
				</div>
			</div>
		</fieldset>
		<fieldset class="margin-25-top">
			<legend>Invoicing</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.invoiced_date.err}">
						<div class="col-lg-10">
							<label class="control-label">Invoiced date</label>
	                    	<input v-model="form.invoiced_date.val" type="date" class="form-control margin-10-top">
	                    	<span v-if="form.invoiced_date.err">{{ form.invoiced_date.msg }}</span>
						</div>
					</div>					
				</div>						
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.invoice_paid_date.err}">
						<div class="col-lg-10">
							<label class="control-label">Invoice paid date</label>
	                    	<input v-model="form.invoice_paid_date.val" type="date" class="form-control margin-10-top">
	                    	<span v-if="form.invoice_paid_date.err">{{ form.invoice_paid_date.msg }}</span>
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
					<button v-if="!isCreating" v-on:click="createProject" class="btn btn-primary btn-block margin-45-top">Save</button>
					<div v-if="isCreating" class="loader"></div>
				</div>					
			</div>
		</div>			
	</fieldset>
</div>

</template>

<script>

	export default {
		data(){
			return {
				form: {
					id: {val: '', err: '', msg: ''},
					province: {val: '', err: '', msg: ''},
					location: {val: '', err: '', msg: ''},
					details: {val: '', err: '', msg: ''},
					client_company_name: {val: '', err: '', msg: ''},
					client_contact_name: {val: '', err: '', msg: ''},
					client_contact_phone: {val: '', err: '', msg: ''},
					client_contact_email: {val: '', err: '', msg: ''},
					first_contact_by: {val: '', err: '', msg: ''},
					first_contact_date: {val: '', err: '', msg: ''},
					land_ownership: {val: '', err: '', msg: ''},
					land_access_granted: {val: 0, err: '', msg: ''},
					land_access_granted_by: {val: '', err: '', msg: ''},
					land_access_contact: {val: '', err: '', msg: ''},
					land_access_phone: {val: '', err: '', msg: ''},
					invoiced_date: {val: '', err: '', msg: ''},
					invoice_paid_date: {val: '', err: '', msg: ''}
				},

				isCreating: false


			}
		},

		methods: {
			clearForm(){
				for(var key in this.form){
					if(key == 'land_access_granted') this.form[key] = 0;
						else this.form[key] = '';
				}
			},

			createProject(){
				// Show loader
				this.isCreating = true;

				// Populate data to send to server
				var data = {};
				for(var key in this.form){
					data[key] = this.form[key].val;
				}
				// Add token
				data._token = window.Laravel.csrfToken;

				// Cache context
				var context = this;

				// Send POST to server
				axios.post('/app/projects/create', data)
					.then(function(response){
						console.log(response);
						// Clear form, notify, and reset loader
		                 noty({
		                     text: 'Project has been created',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
						context.clearForm();
						context.isCreating = false;
						// Alert the parent to what just happened
						this.$emit('project-created', response.data.project);
					})
					.catch(function(response){

					});
			}
		}
		
	}
	
</script>