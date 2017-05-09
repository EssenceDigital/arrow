<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Project Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="currentTab = 'view-all'">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'create-project' }"><a v-on:click="currentTab = 'create-project'">New Project</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div v-if="projects.length > 0" class="col-md-12">
						<div class="col-md-12">
							<table class="table table-striped table-hover margin-25-top">
								<thead>
									<tr class="info">
										<th>Client Company</th>
										<th>Contact Name</th>
										<th>Contact Phone</th>
										<th>Invoice Paid</th>
									</tr>
								</thead>
							  <tbody>
								    <tr v-for="project in projects" v-bind:project="project">
									    <td>{{ project.client_company }}</td>
									    <td>{{ project.client_contact_name }}</td>
									    <td>{{ project.client_contact_phone }}</td>
									    <td>{{ project.invoice_paid_date }}</td>
									    <td>
									    	<dropdown v-bind:title="'Actions'">
								    			<li><a v-on:click="editProject(project.id)">Edit</a></li>
												<li><a v-on:click="viewProjectTable(project.id)">View as table</a></li>
									    	</dropdown>
									    </td>
								    </tr>
							  </tbody>
							</table> 						
						</div>
					</div>

					<div v-if="projects.length == 0" class="col-md-8 col-centered">
						<div class="alert alert-warning text-center">
							<strong>Heads up!</strong><br> No Projects are currently saved in storage.
						</div>							
					</div>	

				</div>

				<div v-if="currentTab == 'create-project'" class="row margin-45-top">
					<div class="col-md-12">
						<div class="well bs-component">
							<form class="form-horizontal">
								<fieldset>
									<legend>Start a project</legend>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.province.err}">
												<div class="col-lg-10">
													<label class="control-label">Province</label>
													<select v-model="form.fields.province.val" class="form-control margin-10-top">
														<option value="" selected disabled="">Select...</option>
								                    	<option value="Alberta">Alberta</option>
								                        <option value="British Columbia">British Columbia</option>
								                        <option value="Saskatchewan">Saskatchewan</option>
								                    </select>
												</div>
											</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.location.err}">
								                <div class="col-lg-10">
								                	<label class="control-label">Location</label>
								                    <textarea v-model="form.fields.location.val" class="form-control margin-10-top" rows="3" placeholder="Specific location"></textarea>
								                    <span v-if="form.fields.location.err">{{ form.fields.location.msg }}</span>
								                </div>
								            </div>						
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.details.err}">
								                <div class="col-lg-10">
								                	<label class="control-label">Details</label>
								                    <textarea v-model="form.fields.details.val" class="form-control margin-10-top" rows="3" placeholder="Project details"></textarea>
								                    <span v-if="form.fields.details.err">{{ form.fields.details.msg }}</span>
								                </div>
								            </div>						
										</div>				
									</div>
								</fieldset>
								<fieldset class="margin-25-top">
									<legend>Client and contact</legend>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_company_name.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client company</label>
							                    	<input v-model="form.fields.client_company_name.val" type="text" class="form-control margin-10-top" placeholder="Name of company">
							                    	<span v-if="form.fields.client_company_name.err">{{ form.fields.client_company_name.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_contact_name.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client contact</label>
							                    	<input v-model="form.fields.client_contact_name.val" type="text" class="form-control margin-10-top" placeholder="Name of contact">
							                    	<span v-if="form.fields.client_contact_name.err">{{ form.fields.client_contact_name.msg }}</span>
							                    </div>
						                  	</div>					
										</div>				
									</div>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_contact_phone.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client contact phone</label>
							                    	<input v-model="form.fields.client_contact_phone.val" type="text" class="form-control margin-10-top" placeholder="Contact phone number">
							                    	<span v-if="form.fields.client_contact_phone.err">{{ form.fields.client_contact_phone.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_contact_email.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client contact email</label>
							                    	<input v-model="form.fields.client_contact_email.val" type="text" class="form-control margin-10-top" placeholder="Contact email">
							                    	<span v-if="form.fields.client_contact_email.err">{{ form.fields.client_contact_email.msg }}</span>
							                    </div>
						                  	</div>					
										</div>				
									</div>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.first_contact_by.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">First contact by</label>
							                    	<input v-model="form.fields.first_contact_by.val" type="text" class="form-control margin-10-top" placeholder="First contact by">
							                    	<span v-if="form.fields.first_contact_by.err">{{ form.fields.first_contact_by.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.first_contact_date.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">First contact date</label>
							                    	<input v-model="form.fields.first_contact_date.val" type="date" class="form-control margin-10-top">
							                    	<span v-if="form.fields.first_contact_date.err">{{ form.fields.first_contact_date.msg }}</span>
							                    </div>
						                  	</div>					
										</div>				
									</div>
								</fieldset>
								<fieldset class="margin-25-top">
									<legend>Land ownership</legend>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_ownership.err}">
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
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_access_granted.err}">
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
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_access_granted_by.err}">
												<div class="col-lg-10">
													<label class="control-label">Land access granted by</label>
							                    	<input v-model="form.fields.land_access_granted_by.val" type="text" class="form-control margin-10-top" placeholder="Access granted by">
							                    	<span v-if="form.fields.land_access_granted_by.err">{{ form.fields.land_access_granted_by.msg }}</span>
												</div>
											</div>					
										</div>						
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_access_contact.err}">
												<div class="col-lg-10">
													<label class="control-label">Land access contact</label>
							                    	<input v-model="form.fields.land_access_contact.val" type="text" class="form-control margin-10-top" placeholder="Access contact name">
							                    	<span v-if="form.fields.land_access_contact.err">{{ form.fields.land_access_contact.msg }}</span>
												</div>
											</div>					
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_access_phone.err}">
												<div class="col-lg-10">
													<label class="control-label">Land access phone</label>
							                    	<input v-model="form.fields.land_access_phone.val" type="text" class="form-control margin-10-top" placeholder="Access contact phone number">
							                    	<span v-if="form.fields.land_access_phone.err">{{ form.fields.land_access_phone.msg }}</span>
												</div>
											</div>						
										</div>
									</div>
								</fieldset>
								<fieldset class="margin-25-top">
									<legend>Invoicing</legend>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.invoiced_date.err}">
												<div class="col-lg-10">
													<label class="control-label">Invoiced date</label>
							                    	<input v-model="form.fields.invoiced_date.val" type="date" class="form-control margin-10-top">
							                    	<span v-if="form.fields.invoiced_date.err">{{ form.fields.invoiced_date.msg }}</span>
												</div>
											</div>					
										</div>						
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.invoice_paid_date.err}">
												<div class="col-lg-10">
													<label class="control-label">Invoice paid date</label>
							                    	<input v-model="form.fields.invoice_paid_date.val" type="date" class="form-control margin-10-top">
							                    	<span v-if="form.fields.invoice_paid_date.err">{{ form.fields.invoice_paid_date.msg }}</span>
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
													<span v-if="!form.isLoading">Change</span>
													<span v-if="form.isLoading">
														<div class="center-loader"></div>
													</span>
												</button>
												
											</div>					
										</div>
									</div>			
								</fieldset>	
						</div>
					</div>					
				</div>

				<modal></modal>

		    </div>
		</div>		
	</div>
</div>

</template>

<script>
	let modal = require('./../ui/Modal.vue');

	export default{
		components: {
			'modal': modal
		},

		data(){
			return {
				currentTab: 'view-all',
				modalActive: false,

				form: {
					isLoading: false,
					fields: {
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
					}

				},

				projects: [],

				fetchingProjects: false

			}
		},

		methods: {
			clearForm(){
				for(var key in this.form.fields.fields){
					if(key == 'land_access_granted') this.form.fields.fields[key] = 0;
						else this.form.fields.fields[key] = '';
				}
			},

			// Sends a GET request to retrieve all projects from the server then sets the projects data prop
			getAndSetProjects(){
				var context = this;
				// Show loader
				this.fetchingProjects = true;
				// Send request
				axios.get('/app/projects/all')
					.then(function(response){
						// Set data prop
						context.projects = response.data.projects;
						// Hide loader
						context.fetchingProjects = false;
					})
					.catch(function(response){
						console.log(response);
					});					
			},

			sendForm(){
				// Show loader
				this.form.isLoading = true;

				// Populate data to send to server
				var data = {};
				for(var key in this.form.fields){
					data[key] = this.form.fields[key].val;
				}
				// Add token
				data._token = window.Laravel.csrfToken;

				// Cache context
				var context = this;
				console.log(this.form.fields);

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
						context.form.isLoading = false;

					})
					.catch(function(error){
						console.log(error.response);
                        if (error.response) {
                            // If the server responded with error data
                            for(var key in error.response.data){
                                context.form.fields[key].msg = error.response.data[key][0];
                                context.form.fields[key].err = true;                                    
                            }
                            // Hide loader
                            context.form.isLoading = false;

                        }
					});
			},

			// Retrieves all projects from storage upon compenent mounting
			mounted(){
				this.getAndSetProjects();
			}

		}
	}

</script>