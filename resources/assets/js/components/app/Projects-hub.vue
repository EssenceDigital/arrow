<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Project Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="viewAllProjectsTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'view-form' }"><a v-on:click="viewProjectFormTab">{{ form.title }}</a></li>
					<li v-if="currentTab == 'view-table'" v-bind:class="{ 'active': currentTab == 'view-table' }"><a>Project as Table</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div v-if="models.length > 0" class="col-md-12">
						<button v-on:click="getAndSetProjects" class="btn btn-default">
							<span class="glyphicon glyphicon-refresh"></span>
							<span v-if="!fetchingModels"> Refresh list</span>
							<span v-if="fetchingModels">
								<div class="left-loader"></div>
							</span>
						</button>					
						<table class="table table-striped table-hover margin-25-top">
							<thead>
								<tr class="info">
									<th>Client Company</th>
									<th>Contact Name</th>
									<th>Contact Phone</th>
									<th>Invoice Paid</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							    <tr v-for="project in models" v-bind:project="project">
								    <td>{{ project.client_company_name }}</td>
								    <td>{{ project.client_contact_name }}</td>
								    <td><a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a></td>
								    <td><div v-if="project.invoiced_date == null" class="text-warning">Not Invoiced</div></td>
								    <td>
								    	<dropdown v-bind:title="'Actions'">
							    			<li><a v-on:click="editProject(project.id)">Edit</a></li>
											<li><a v-on:click="viewProjectTable(project.id)">View as table</a></li>
								    	</dropdown>
								    </td>
							    </tr>
							</tbody>
						</table>

						<div class="row text-center margin-45-top">
							<ul class="pagination">
								<li v-bind:class="{ 'disabled': modelsCurrentPage == 1 }"><a v-on:click="getSpecificProjectsPage(modelsPrevPageUrl)">«</a></li>
								<li v-for="(page, key) in modelsPageLinks" v-bind:class="{ 'active': modelsCurrentPage == key }">
									<a v-on:click="getSpecificProjectsPage(page)">{{ key }}</a>
								</li>
								<li v-bind:class="{ 'disabled': modelsCurrentPage == modelsPageTotal }"><a v-on:click="getSpecificProjectsPage(modelsNextPageUrl)">»</a></li>
							</ul>							
						</div>

					</div>

					<div v-if="models.length == 0" class="col-md-8 col-centered">
						<div class="alert alert-warning text-center">
							<strong>Heads up!</strong><br> No Projects are currently saved in storage.
						</div>							
					</div>	

				</div>

				<div v-if="currentTab == 'view-form'" class="row margin-45-top">
					<div class="col-md-12">
						<button v-if="form.state == 'edit'" v-on:click="viewProjectTable(form.fields.id.val)" class="btn btn-default">
							<span class="glyphicon glyphicon-list-alt"></span> View as Table
						</button>					
						<div class="well bs-component margin-25-top">
							<form class="form-horizontal">
								<fieldset>
									<legend>{{ form.title }}</legend>
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
								                    <span class="text-danger" v-if="form.fields.province.err">{{ form.fields.province.err }}</span>
												</div>
											</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.location.err}">
								                <div class="col-lg-10">
								                	<label class="control-label">Location</label>
								                    <textarea v-model="form.fields.location.val" class="form-control margin-10-top" rows="3" placeholder="Specific location"></textarea>
								                    <span class="text-danger" v-if="form.fields.location.err">{{ form.fields.location.err }}</span>
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
								                    <span class="text-danger" v-if="form.fields.details.err">{{ form.fields.details.err }}</span>
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
							                    	<span class="text-danger" v-if="form.fields.client_company_name.err">{{ form.fields.client_company_name.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_contact_name.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client contact</label>
							                    	<input v-model="form.fields.client_contact_name.val" type="text" class="form-control margin-10-top" placeholder="Name of contact">
							                    	<span class="text-danger" v-if="form.fields.client_contact_name.err">{{ form.fields.client_contact_name.err }}</span>
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
							                    	<span class="text-danger" v-if="form.fields.client_contact_phone.err">{{ form.fields.client_contact_phone.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.client_contact_email.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Client contact email</label>
							                    	<input v-model="form.fields.client_contact_email.val" type="text" class="form-control margin-10-top" placeholder="Contact email">
							                    	<span class="text-danger" v-if="form.fields.client_contact_email.err">{{ form.fields.client_contact_email.err }}</span>
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
							                    	<span class="text-danger" v-if="form.fields.first_contact_by.err">{{ form.fields.first_contact_by.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.first_contact_date.err}">
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
							                    	<span class="text-danger" v-if="form.fields.land_access_granted_by.err">{{ form.fields.land_access_granted_by.err }}</span>
												</div>
											</div>					
										</div>						
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.land_access_contact.err}">
												<div class="col-lg-10">
													<label class="control-label">Land access contact</label>
							                    	<input v-model="form.fields.land_access_contact.val" type="text" class="form-control margin-10-top" placeholder="Access contact name">
							                    	<span class="text-danger" v-if="form.fields.land_access_contact.err">{{ form.fields.land_access_contact.err }}</span>
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
											<div class="form-group" v-bind:class="{'has-error': form.fields.invoiced_date.err}">
												<div class="col-lg-10">
													<label class="control-label">Invoiced date</label>
							                    	<input v-model="form.fields.invoiced_date.val" type="date" class="form-control margin-10-top">
							                    	<span class="text-danger" v-if="form.fields.invoiced_date.err">{{ form.fields.invoiced_date.err }}</span>
												</div>
											</div>					
										</div>						
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.invoice_paid_date.err}">
												<div class="col-lg-10">
													<label class="control-label">Invoice paid date</label>
							                    	<input v-model="form.fields.invoice_paid_date.val" type="date" class="form-control margin-10-top">
							                    	<span class="text-danger" v-if="form.fields.invoice_paid_date.err">{{ form.fields.invoice_paid_date.err }}</span>
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

						<div v-if="form.state == 'edit'" class="well bs-component">
							<legend class="danger">Delete Project</legend>
							<fieldset>
								<div class="row">
									<div class="col-md-3 col-centered">
										<div class="form-group">
											<button v-on:click="modalActive = true" class="btn btn-danger btn-block margin-45-top">Delete</button>
										</div>					
									</div>
								</div>			
							</fieldset>								
						</div>

						<modal v-bind:modalActive="modalActive" v-on:modal-close="modalActive = false">
							<h4 slot="title" class="danger">
								Delete this project?
							</h4>
							<p slot="body">
								Delete this project until the age that gave it birth comes again?
							</p>
							<div slot="footer">
								<button v-on:click="modalActive = false" class="btn btn-primary margin-45-top">Cancel</button>
								<button v-on:click="deleteProject" class="btn btn-danger margin-45-top">
									<span v-if="!isDeleting">Delete</span>
									<span v-if="isDeleting">
										<div class="loader-center"></div>
									</span>
								</button>
							</div>
						</modal>

					</div>					
				</div>

				<div v-if="currentTab == 'view-table'" class="row margin-45-top">

					<div class="col-md-12">
						<button v-on:click="editProject(form.fields.id.val)" class="btn btn-default">
							<span class="glyphicon glyphicon-cog"></span> Edit Project
						</button>
						<button v-if="form.fields.proposal.val" v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Edit Proposal
						</button>						
						<button v-else v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Add Proposal
						</button>
					</div>

					<div v-if="projectSubTab == 'view-project'" class="col-md-12 margin-25-top">
						<h3>Project Details</h3>

						<div class="col-md-12 margin-25-top">
							<h4>Location</h4>
							<div class="col-md-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Province</strong></h5>
								    	<div v-if="form.fields.province.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.province.val }}
								    	</div>									
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="panel panel-default">									
									<div class="panel-body">
										<h5><strong>Location</strong></h5>
								    	<div v-if="form.fields.location.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.location.val }}
								    	</div>										
									</div>
								</div>
							</div>								

							<div class="col-md-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Details</strong></h5>
								    	<div v-if="form.fields.details.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.details.val }}
								    	</div>									
									</div>
								</div>
							</div>

						</div>

						<div class="col-md-12 margin-25-top">
							<h4>Client</h4>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Client</strong></h5>
								    	<div v-if="form.fields.client_company_name.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.client_company_name.val }}
								    	</div>									
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Client Contact</strong></h5>
								    	<div v-if="form.fields.client_contact_name.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.client_contact_name.val }}
								    	</div>										
									</div>
								</div>
							</div>								

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Contact Phone</strong></h5>
								    	<div v-if="form.fields.client_contact_phone.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		<a v-bind:href="'tel: +1' + form.fields.client_contact_phone.val.replace(/-/g, '')">{{ form.fields.client_contact_phone.val }}</a>
								    	</div>										
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Contact Email</strong></h5>
								    	<div v-if="form.fields.client_contact_email.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.client_contact_email.val }}
								    	</div>									
									</div>
								</div>
							</div>

						</div>

						<div class="col-md-12 margin-25-top">
							<h4>Land</h4>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Land Ownership</strong></h5>
								    	<div v-if="form.fields.land_ownership.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.land_ownership.val }}
								    	</div>									
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Access Granted</strong></h5>
								    	<div v-if="form.fields.land_access_granted.val == 0">No</div>
								    	<div v-if="form.fields.land_access_granted.val == 1">Yes</div>
									</div>
								</div>
							</div>								

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Access Granted By</strong></h5>
								    	<div v-if="form.fields.land_access_granted_by.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.land_access_granted_by.val }}
								    	</div>									
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Access Contact</strong></h5>
								    	<div v-if="form.fields.land_access_contact.val == null">
								    		<span class="label label-warning">N/A</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.land_access_contact.val }}
								    	</div>									
									</div>
								</div>
							</div>

						</div>

						<div class="col-md-12 margin-25-top">
							<h4 class="text-success">Invoicing</h4>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<h5><strong>Invoiced Date</strong></h5>
								    	<div v-if="form.fields.invoiced_date.val == null">
								    		<span class="label label-warning">Not Invoiced</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.invoiced_date.val }}
								    	</div>									
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="panel panel-default">									
									<div class="panel-body">
										<h5><strong>Date Paid</strong></h5>
								    	<div v-if="form.fields.invoice_paid_date.val == null">
								    		<span class="label label-warning">Not Invoiced</span>
								    	</div>
								    	<div v-else>
								    		{{ form.fields.invoice_paid_date.val }}
								    	</div>										
									</div>
								</div>
							</div>								

						</div>

						<div v-if="form.fields.proposal.val" class="row margin-65-top">
							<div class="col-md-12">
								<h3>Project Proposal</h3>

								<div class="col-md-12 margin-25-top">
									<h4>Work Details</h4>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Work Type</strong></h5>
										    	<div v-if="form.fields.proposal.val.work_type == null">
										    		<span class="label label-warning">N/A</span>
										    	</div>
										    	<div v-else>
										    		{{ form.fields.proposal.val.work_type }}
										    	</div>									
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Work Overview</strong></h5>
										    	<div v-if="form.fields.proposal.val.work_overview == null">
										    		<span class="label label-warning">N/A</span>
										    	</div>
										    	<div v-else>
										    		{{ form.fields.proposal.val.work_overview }}
										    	</div>									
											</div>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Work Plans</strong></h5>
										    	<div v-if="form.fields.proposal.val.plans == null">
										    		<span class="label label-warning">N/A</span>
										    	</div>
										    	<div v-else>
										    		{{ form.fields.proposal.val.plans }}
										    	</div>									
											</div>
										</div>
									</div>																	
								</div>	

								<div class="col-md-12 margin-25-top">
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Estimate</strong></h5>
										    	<div v-if="form.fields.proposal.val.estimate == null">
										    		<span class="label label-warning">N/A</span>
										    	</div>
										    	<div v-else>
										    		${{ form.fields.proposal.val.estimate }}
										    	</div>									
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Response By</strong></h5>
										    	<div v-if="form.fields.proposal.val.response_by == null">
										    		<span class="label label-warning">N/A</span>
										    	</div>
										    	<div v-else>
										    		{{ form.fields.proposal.val.response_by }}
										    	</div>									
											</div>
										</div>
									</div>																		
								</div>	

								<div class="col-md-12 margin-25-top">
									<h4>Project Approval</h4>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<h5><strong>Approval Date</strong></h5>
										    	<div v-if="form.fields.proposal.val.approval_date == null">
										    		<span class="label label-danger">Not yet approved</span>
										    	</div>
										    	<div v-else>
										    		{{ form.fields.proposal.val.approval_date }}
										    	</div>									
											</div>
										</div>
									</div>																	
								</div>																							

							</div>	
						</div>											
					
					</div><!-- / view-project sub tab -->	

					<div v-if="projectSubTab == 'proposal-form'" class="col-md-12 margin-25-top">
						<proposal-form v-bind:proposal="form.fields.proposal.val" v-bind:project_id="form.fields.id.val">
							<button slot="close" v-on:click="projectSubTab = 'view-project'" type="button" class="pull-right btn btn-danger">
								&times;
							</button>
						</proposal-form>
					</div><!-- / add-proposal sub tab -->	

				</div><!-- / view-table tab -->

		    </div>
		</div>		
	</div>
</div>

</template>

<script>
	let proposal_form = require('./Proposal-form.vue');
	let modal = require('./../ui/Modal.vue');
	let dropdown = require('./../ui/Dropdown.vue');
	let hub_controller = require('./mixins/hub-controller.js');

	export default{
		components: {
			'proposal-form': proposal_form,
			'modal': modal,
			'dropdown': dropdown
		},

		mixins: [hub_controller],

		data(){
			return {
				currentTab: 'view-all',
				projectSubTab: 'view-project',
				modalActive: false,
				urlToDelete: '/app/projects/delete',
				isDeleting: false,
				urlToFetch: '/app/projects/all',				
				fetchingModels: false,	
				models: [],	
				modelsPageTotal: 0,
				modelsCurrentPage: 0,
				modelsPageLinks: {},
				modelsNextPageUrl: '',
				modelsPrevPageUrl: '',					
				form: {
					model: 'Project',
					state: 'create',
					title: 'Create Project',
					button: 'Save',
					action: '/app/projects/create',
					createAction: '/app/projects/create',
					updateAction: '/app/projects/update',
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

		methods: {

			viewAllProjectsTab(){
				this.viewAllModelsTab();
			},

			viewProjectFormTab(){
				this.viewFormTab();
			},

			getAndSetProjects(){
				this.getAndSetModels();
			},

			getSpecificProjectsPage(link){
				this.getAndSetModels(link);
			},

			viewProjectTable(id){
				this.viewModelAsTable(id);
			},

			editProject(id){
				this.prepareFormForEdit('/app/projects/' + id);
			},

			editProposal(id){
				
			},

			sendForm(){
				this.createOrUpdate();
			},

			deleteProject(){
				this.deleteModel();
			}

		},

		// Retrieves all projects from storage upon compenent mounting
		mounted(){
			this.getAndSetModels();
		}

	}

</script>