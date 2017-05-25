<template>

<!-- Component container -->
<div>
	<!-- Loader - shows if data is fetching -->
	<div v-if="formIsLoading" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<!-- Contains edit and delete forms - only shows after loading -->
	<div v-if="!formIsLoading">
		<!-- 'Well' to hold form -->
		<div class="well bs-component margin-25-top">
			<!-- The project form -->
			<form @submit.prevent class="form-horizontal">
				<fieldset>
					<legend>
						{{ form.title }}
						<button 
							slot="close"
							@click="$router.go(-1)" 
							class="pull-right btn btn-danger"
						>
							&times;
						</button>
					</legend>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.province.err}">
								<div class="col-lg-10">
									<label class="control-label">Province</label>
									<select v-model="form.fields.province.val" class="form-control margin-10-top">
										<option value="" selected disabled="">Select...</option>
				                    	<option value="Alberta">Alberta</option>
				                        <option value="British Columbia">British Columbia</option>
				                        <option value="Saskatchewan">Saskatchewan</option>
				                    </select>
				                    <span v-if="form.fields.province.err" class="text-danger" >{{ form.fields.province.err }}</span>
								</div>
							</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.location.err}">
				                <div class="col-lg-10">
				                	<label class="control-label">Location</label>
				                    <textarea v-model="form.fields.location.val" class="form-control margin-10-top" rows="3" placeholder="Specific location"></textarea>
				                    <span v-if="form.fields.location.err" class="text-danger">{{ form.fields.location.err }}</span>
				                </div>
				            </div>						
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.details.err}">
				                <div class="col-lg-10">
				                	<label class="control-label">Details</label>
				                    <textarea v-model="form.fields.details.val" class="form-control margin-10-top" rows="3" placeholder="Project details"></textarea>
				                    <span class="text-danger" v-if="form.fields.details.err">{{ form.fields.details.err }}</span>
				                </div>
				            </div>						
						</div>				
					</div>
				</fieldset>
				<fieldset class="margin-25-top">
					<legend>Client and contact</legend>
					<div class="row">
						<div v-if="form.state != 'edit'" class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.province.err}">
								<div class="col-lg-10">
									<label class="control-label">Client company</label>
									<select v-model="client_company_name" class="form-control margin-10-top">
										<option value="" selected>Select existing client...</option>
										<option v-for="client in clients" 
											:value="client"
										>
											{{ client }}
										</option>
				                    </select>
				                    <span v-if="client_company_name.err" class="text-danger" >{{ form.fields.client_company_name.err }}</span>
								</div>
							</div>					
						</div>							
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.client_company_name.err}">
			                    <div class="col-lg-10">
			                    	<label v-if="form.state != 'edit'" class="control-label">Add new company</label>
			                    	<label v-else class="control-label">Company name</label>
			                    	<input v-model="form.fields.client_company_name.val" type="text" class="form-control margin-10-top" placeholder="New client name" :disabled="disableClientCompanyInput">
			                    	<span class="text-danger" v-if="form.fields.client_company_name.err">{{ form.fields.client_company_name.err }}</span>
			                    </div>
		                  	</div>					
						</div>

					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.client_contact_name.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Client contact</label>
			                    	<input v-model="form.fields.client_contact_name.val" type="text" class="form-control margin-10-top" placeholder="Name of contact">
			                    	<span class="text-danger" v-if="form.fields.client_contact_name.err">{{ form.fields.client_contact_name.err }}</span>
			                    </div>
		                  	</div>					
						</div>						
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.client_contact_phone.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Client contact phone</label>
			                    	<input v-model="form.fields.client_contact_phone.val" type="text" class="form-control margin-10-top" placeholder="Contact phone number">
			                    	<span class="text-danger" v-if="form.fields.client_contact_phone.err">{{ form.fields.client_contact_phone.err }}</span>
			                    </div>
		                  	</div>					
						</div>
					
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.client_contact_email.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Client contact email</label>
			                    	<input v-model="form.fields.client_contact_email.val" type="text" class="form-control margin-10-top" placeholder="Contact email">
			                    	<span class="text-danger" v-if="form.fields.client_contact_email.err">{{ form.fields.client_contact_email.err }}</span>
			                    </div>
		                  	</div>					
						</div>						
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.first_contact_by.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">First contact by</label>
			                    	<input v-model="form.fields.first_contact_by.val" type="text" class="form-control margin-10-top" placeholder="First contact by">
			                    	<div class="checkbox">
										<label>
											<input type="checkbox"
												v-model="firstContactChecked"
											> 
												Same person as client contact?
										</label>
									</div>
			                    	<span class="text-danger" v-if="form.fields.first_contact_by.err">{{ form.fields.first_contact_by.err }}</span>
			                    </div>
		                  	</div>					
						</div>				
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.first_contact_date.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">First contact date</label>
			                    	<input v-model="form.fields.first_contact_date.val" type="date" class="form-control margin-10-top">
			                    	<span class="text-danger" v-if="form.fields.first_contact_date.err">{{ form.fields.first_contact_date.err }}</span>
			                    </div>
		                  	</div>					
						</div>						
					</div>
				</fieldset>
				<fieldset class="margin-25-top">
					<legend>Land ownership</legend>
					<div class="row">			
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.land_ownership.err}">
								<div class="col-lg-10">
									<label class="control-label">Land ownership</label>
									<select v-model="form.fields.land_ownership.val" class="form-control margin-10-top">
										<option value="" selected disabled="">Select...</option>
				                    	<option>Crown</option>
				                        <option>Freehold</option>
				                    </select>
								</div>
							</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.land_access_granted.err}">
								<div class="col-lg-10">
									<label class="control-label">Land access granted</label>
									<select v-model="form.fields.land_access_granted.val" class="form-control margin-10-top">
										<option value="0">No</option>
				                    	<option value="1">Yes</option>
				                    </select>
								</div>
							</div>					
						</div>				
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.land_access_granted_by.err}">
								<div class="col-lg-10">
									<label class="control-label">Land access granted by</label>
			                    	<input v-model="form.fields.land_access_granted_by.val" type="text" class="form-control margin-10-top" placeholder="Access granted by">		                    	
			                    	<span class="text-danger" v-if="form.fields.land_access_granted_by.err">{{ form.fields.land_access_granted_by.err }}</span>
								</div>
							</div>					
						</div>						
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.land_access_contact.err}">
								<div class="col-lg-10">
									<label class="control-label">Land access contact</label>
			                    	<input v-model="form.fields.land_access_contact.val" type="text" class="form-control margin-10-top" placeholder="Access contact name">
			                    	<div class="checkbox">
										<label>
											<input type="checkbox"
												v-model="accessContactChecked"
											> 
												Same person as land access granted by?
										</label>
									</div>		                    	
			                    	<span class="text-danger" v-if="form.fields.land_access_contact.err">{{ form.fields.land_access_contact.err }}</span>
								</div>
							</div>					
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.land_access_phone.err}">
								<div class="col-lg-10">
									<label class="control-label">Land access phone</label>
			                    	<input v-model="form.fields.land_access_phone.val" type="text" class="form-control margin-10-top" placeholder="Access contact phone number">
			                    	<span class="text-danger" v-if="form.fields.land_access_phone.err">{{ form.fields.land_access_phone.err }}</span>
								</div>
							</div>						
						</div>
					</div>
				</fieldset>
				<fieldset class="margin-25-top">
					<legend>Invoicing</legend>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.invoiced_date.err}">
								<div class="col-lg-10">
									<label class="control-label">Invoiced date</label>
			                    	<input v-model="form.fields.invoiced_date.val" type="date" class="form-control margin-10-top">
			                    	<span class="text-danger" v-if="form.fields.invoiced_date.err">{{ form.fields.invoiced_date.err }}</span>
								</div>
							</div>					
						</div>						
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.invoice_paid_date.err}">
								<div class="col-lg-10">
									<label class="control-label">Invoice paid date</label>
			                    	<input v-model="form.fields.invoice_paid_date.val" type="date" class="form-control margin-10-top">
			                    	<span class="text-danger" v-if="form.fields.invoice_paid_date.err">{{ form.fields.invoice_paid_date.err }}</span>
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
			</form><!-- / project form -->	
		</div><!-- 'Well' to hold form -->

		<!-- 'Well' for delete button (triggers the modal below to confirm) -->	
		<div v-if="form.state == 'edit'" class="well bs-component">
			<legend class="danger">Delete Project</legend>
			<fieldset>
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<!-- Triggers the modal below to confirm removal -->
							<button @click="modalActive = true" class="btn btn-danger btn-block margin-45-top">
								Delete
							</button>
						</div>					
					</div>
				</div>			
			</fieldset>								
		</div><!-- 'Well' for delete button -->

		<!-- Modal to confirm deletion -->
		<modal :modalActive="modalActive" 
			@modal-close="modalActive = false"
		>
			<h4 slot="title" class="danger">
				Delete this project?
			</h4>
			<p slot="body">
				Delete this project until the age that gave it birth comes again?
			</p>
			<div slot="footer">
				<button @click="modalActive = false" class="btn btn-primary margin-45-top">
					Cancel
				</button>
				<button @click="deleteProject" class="btn btn-danger margin-45-top">
					<span v-if="!isDeleting">Delete</span>
					<span v-if="isDeleting">
						<div class="loader-center"></div>
					</span>
				</button>
			</div>
		</modal><!--- / Modal -->
	</div><!-- / Contains forms -->
</div><!-- / Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');
	let modal = require('./../_ui/Modal.vue');
	
	export default{
		components: {
			'modal': modal
		},

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				modalActive: false,
				urlToDelete: '/api/projects/delete',
				isDeleting: false,		
				clients: [],
				client_company_name: '',
				disableClientCompanyInput: false,
				firstContactChecked: false,	
				accessContactChecked: false,
				form: {
					model: 'Project',
					state: 'create',
					title: 'Create Project',
					button: 'Save',
					action: '/api/projects/create',
					createAction: '/api/projects/create',
					updateAction: '/api/projects/update',
					isLoading: false,					
					successMsg: 'Project has been saved',
					fields: {
						id: {val: '', err: false, dflt: ''},
						province: {val: '', err: false, dflt: ''},
						location: {val: '', err: false, dflt: ''},
						details: {val: '', err: false, dflt: ''},
						client_company_name: {val: '', err: false, dflt: ''},
						client_contact_name: {val: '', err: false, dflt: ''},
						client_contact_phone: {val: '', err: false, dflt: ''},
						client_contact_email: {val: '', err: false, dflt: ''},
						first_contact_by: {val: '', err: false, dflt: ''},
						first_contact_date: {val: '', err: false, dflt: ''},
						land_ownership: {val: '', err: false, dflt: ''},
						land_access_granted: {val: 0, err: false, dflt: 0},
						land_access_granted_by: {val: '', err: false, dflt: ''},
						land_access_contact: {val: '', err: false, dflt: ''},
						land_access_phone: {val: '', err: false, dflt: ''},
						invoiced_date: {val: '', err: false, dflt: ''},
						invoice_paid_date: {val: '', err: false, dflt: ''},
						proposal: {val: '', err: false, dflt: ''}				
					}
				}				
			}
		},

		watch: {
			// For the dual client company input setup. If a select option is selected then
			// set the selected value to the form property and disable the text input. 
			client_company_name(value){
				// If a value is present
				if(value != ''){
					this.form.fields.client_company_name.val = value;
					this.disableClientCompanyInput = true;
				} else{
					// If empty string then enable text input again
					this.disableClientCompanyInput = false;
				}
			},

			// When the value changes (checkbox) adjust values
			firstContactChecked(value){
				if(value){
					this.form.fields.first_contact_by.val = this.form.fields.client_contact_name.val;
				} else{
					this.form.fields.first_contact_by.val = '';
				}
			},

			// When the value changes (checkbox) adjust values
			accessContactChecked(value){
				if(value){
					this.form.fields.land_access_contact.val = this.form.fields.land_access_granted_by.val;
				} else{
					this.form.fields.land_access_contact.val = '';
				}
			}
		},

		methods: {
			// Submits the form to server via mixin
			sendForm(){
				this.createOrUpdate();
			},

			// Submits a delete to server via mixin
			deleteProject(){
				this.deleteModel();
			},

			// Retrieve all the unique clients from api
			getAndSetUniqueClients(){
				var context = this;
				// Send request to retrieve unique clients
				axios.get('/api/projects/unique-clients')
					.then(function(response){
						// Set the clients prop
						context.clients = response.data.clients;
					})
					.catch(function(error){
						console.log(error);
					});
			}			
		},

		// If an id is in the route then retrieve the model from server
		created(){
			console.log('Project form created');			

			// If an id is present then set up the form for edit
			if(this.$route.params.id){
				// Show form loader
				this.formIsLoading = true;
				// Get the requested model
				this.grabModel('/api/projects/' + this.$route.params.id, function(model){
					// Populate form
					this.populateFormFromModel(model);
					// Adjust form state
					this.formEditState('edit');
					// Hide form loader
					this.formIsLoading = false;
				});								
			} else{
				// Find unique clients for a new project
				this.getAndSetUniqueClients();
			}
		}

	}

</script>