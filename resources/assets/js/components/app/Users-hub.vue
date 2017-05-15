<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Users Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="viewAllUsersTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'view-form' }"><a v-on:click="viewUserFormTab">{{ form.title }}</a></li>
					<li v-if="currentTab == 'view-table'" v-bind:class="{ 'active': currentTab == 'view-table' }"><a>User as Table</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div v-if="models.length > 0" class="col-md-12">
						<button v-on:click="getAndSetUsers" class="btn btn-default">
							<span class="glyphicon glyphicon-refresh"></span>
							<span v-if="!fetchingModels"> Refresh list</span>
							<span v-if="fetchingModels">
								<div class="left-loader"></div>
							</span>
						</button>
						<table class="table table-striped table-hover margin-25-top">
							<thead>
								<tr class="info">
									<th>Name</th>
									<th>Email</th>
									<th>Permissions</th>
									<th>Actions</th>
								</tr>
							</thead>
						  <tbody>
							    <tr v-for="user in models" v-bind:user="user">
								    <td>{{ user.first + ' ' + user.last }}</td>
								    <td>{{ user.email }}</td>
								    <td>{{ user.permissions }}</td>
								    <td>
								    	<dropdown v-bind:title="'Actions'">
							    			<li><a v-on:click="editUser(user.id)">Edit</a></li>
											<li><a v-on:click="viewUserTable(user.id)">View as table</a></li>
								    	</dropdown>
								    </td>
							    </tr>
						  </tbody>
						</table>
					</div>

					<div v-if="models.length == 0" class="col-md-8 col-centered">
						<div class="alert alert-warning text-center">
							<strong>Heads up!</strong><br> No users are currently saved in storage.
						</div>							
					</div>																
				</div>

				<div v-if="currentTab == 'view-form'" class="row margin-45-top">
					<div class="col-md-12">
						<button v-if="form.state == 'edit'" v-on:click="viewUserTable(form.fields.id.val)" class="btn btn-default">
							<span class="glyphicon glyphicon-list-alt"></span> View as Table
						</button>
						<div class="well bs-component margin-25-top">
							<form class="form-horizontal">
								<fieldset class="margin-25-top">
									<legend>{{ form.title }}</legend>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.first.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">First Name</label>
							                    	<input v-model="form.fields.first.val" type="text" class="form-control margin-10-top" placeholder="First">
							                    	<span class="text-danger" v-if="form.fields.first.err">{{ form.fields.first.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.last.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Last Name</label>
							                    	<input v-model="form.fields.last.val" type="text" class="form-control margin-10-top" placeholder="Last">
							                    	<span class="text-danger" v-if="form.fields.last.err">{{ form.fields.last.err }}</span>
							                    </div>
						                  	</div>					
										</div>				
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.email.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Email (used as username)</label>
							                    	<input v-model="form.fields.email.val" type="email" class="form-control margin-10-top" placeholder="Email address">
							                    	<span class="text-danger" v-if="form.fields.email.err">{{ form.fields.email.err }}</span>
							                    </div>
						                  	</div>					
										</div>			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.permissions.err}">
												<div class="col-lg-10">
													<label class="control-label">Permissions</label>
													<select v-model="form.fields.permissions.val" class="form-control margin-10-top">
														<option value="" selected disabled="">Select...</option>
								                    	<option value="user">User</option>
								                        <option value="admin">Administrator</option>
								                    </select>
												</div>
											</div>					
										</div>
									</div>
									<div v-if="form.state == 'create'" class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Initial Password</label>
							                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="Password">
							                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
							                    	<span class="text-danger" v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.err }}</span>
							                    </div>
						                  	</div>					
										</div>												
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.company_name.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Company Name</label>
							                    	<input v-model="form.fields.company_name.val" type="text" class="form-control margin-10-top" placeholder="Company name">
							                    	<span class="text-danger" v-if="form.fields.company_name.err">{{ form.fields.company_name.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.gst_number.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">GST Number</label>
							                    	<input v-model="form.fields.gst_number.val" type="text" class="form-control margin-10-top" placeholder="GST No.">
							                    	<span class="text-danger" v-if="form.fields.gst_number.err">{{ form.fields.gst_number.err }}</span>
							                    </div>
						                  	</div>					
										</div>												
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.hourly_rate_one.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Hourly Rate One</label>
							                    	<div class="input-group margin-10-top">
							                    		<span class="input-group-addon">$</span>
							                    		<input v-model="form.fields.hourly_rate_one.val" type="text" class="form-control" placeholder="Hourly rate one">
							                    	</div>	                    	
							                    	<span class="text-danger" v-if="form.fields.hourly_rate_one.err">{{ form.fields.hourly_rate_one.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.hourly_rate_two.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Hourly Rate Two</label>
							                    	<div class="input-group margin-10-top">
							                    		<span class="input-group-addon">$</span>
							                    		<input v-model="form.fields.hourly_rate_two.val" type="text" class="form-control" placeholder="Hourly rate two">
							                    	</div>
							                    	<span class="text-danger" v-if="form.fields.hourly_rate_two.err">{{ form.fields.hourly_rate_two.err }}</span>
							                    </div>
						                  	</div>						
										</div>												
									</div>						
								</fieldset>
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

						<div v-if="form.state == 'edit'" class="well bs-component">
							<form v-on:submit.prevent="onSubmit" class="form-horizontal">
								<legend>Change Password</legend>
								<fieldset class="margin-25-top">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">New Password</label>
							                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="Password">
							                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
							                    	<span class="text-danger" v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.err }}</span>
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
											<button v-on:click="changePassword" class="btn btn-primary btn-block margin-45-top">
												<span v-if="!passwordIsChanging">Change</span>
												<span v-if="passwordIsChanging">
													<div class="center-loader"></div>
												</span>
											</button>
											
										</div>					
									</div>
								</div>			
							</fieldset>								
						</div>

						<div v-if="form.state == 'edit'" class="well bs-component">
							<legend class="danger">Delete User</legend>
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
								Delete this user?
							</h4>
							<p slot="body">
								Delete this user until the age that gave it birth comes again?
							</p>
							<div slot="footer">
								<button v-on:click="modalActive = false" class="btn btn-primary margin-45-top">Cancel</button>
								<button v-on:click="deleteUser" class="btn btn-danger margin-45-top">
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
						<button v-on:click="editUser(form.fields.id.val)" class="btn btn-default">
							<span class="glyphicon glyphicon-cog"></span> Edit User
						</button>					
						<table class="table table-striped table-hover margin-25-top">
							<thead>
								<tr class="info">
									<th>Name</th>
									<th>Email</th>
									<th>Permissions</th>
								</tr>
							</thead>
							<tbody>
							    <tr>
								    <td>{{ form.fields.first.val + ' ' + form.fields.last.val }}</td>
								    <td>{{ form.fields.email.val }}</td>
								    <td>{{ form.fields.permissions.val }}</td>
							    </tr>
							</tbody>
						</table>						
					</div>

					<div class="col-md-12">
						<table class="table table-striped table-hover margin-25-top">
							<thead>
								<tr class="info">
									<th>Company Name</th>
									<th>GST No.</th>
									<th>Hourly No. 1</th>
									<th>Hourly No. 2</th>
								</tr>
							</thead>
							<tbody>
							    <tr>
								    <td>{{ form.fields.company_name.val }}</td>
								    <td>{{ form.fields.gst_number.val }}</td>
								    <td>${{ form.fields.hourly_rate_one.val }}</td>
								    <td>${{ form.fields.hourly_rate_two.val }}</td>
							    </tr>
							</tbody>
						</table>						
					</div>					
					
				</div>

		    </div>
		</div>		
	</div>
</div>
	
</template>

<script>
	let modal = require('./../ui/Modal.vue');
	let dropdown = require('./../ui/Dropdown.vue');
	let hub_controller = require('./mixins/hub-controller.js');

	export default{
		components: {
			'modal': modal,
			'dropdown': dropdown
		},

		mixins: [hub_controller],

		data(){
			return {
				currentTab: 'view-all',
				modalActive: false,
				urlToDelete: '/app/users/delete',
				isDeleting: false,
				passwordIsChanging: false,
				urlToFetch: '/app/users/all',
				fetchingModels: false,
				models: [],
				form:{
					model: 'User',
					state: 'create',
					title: 'Create User',
					button: 'Save',
					action: '/app/users/create',
					createAction: '/app/users/create',
					updateAction: '/app/users/update',					
					isLoading: false,
					successMsg: 'User has been saved',
					fields: {
						id: {val: '', err: false, dflt: ''},
						first: {val: '', err: false, dflt: ''},
						last: {val: '', err: false, dflt: ''},
						permissions: {val: '', err: false, dflt: ''},
						email: {val: '', err: false, dflt: ''},
						password: {val: '', err: false, dflt: ''},
						password_confirmation: {val: '', err: false, dflt: ''},
						company_name: {val: '', err: false, dflt: ''},
						hourly_rate_one: {val: '0.00', err: false, dflt: '0.00'},
						hourly_rate_two: {val: '0.00', err: false, dflt: '0.00'},
						gst_number: {val: '', err: false, dflt: ''}						
					}
				},
				
			}
		},

		methods: {

			viewAllUsersTab(){
				this.viewAllModelsTab();
			},

			viewUserFormTab(){
				this.viewFormTab();
			},

			getAndSetUsers(){
				this.getAndSetModels();
			},

			viewUserTable(id){
				this.viewModelAsTable(id);
			},

			editUser(id){
				this.prepareFormForEdit('/app/users/' + id);
			},

			sendForm(){
				this.createOrUpdate();
			},

			deleteUser(){
				this.deleteModel();
			},

			// Sends a POST request to change a specific users password in storage
			changePassword(){
				// Show loader
				this.passwordIsChanging = true;
				// Assemble object for POST
				var data = {
					id: this.form.fields.id.val,
					password: this.form.fields.password.val,
					password_confirmation: this.form.fields.password_confirmation.val,
					_token: window.Laravel.csrfToken
				};
				// Cache context
				var context = this;
				// Send POST to server
				axios.post('/app/users/change-password', data)
					.then(function(response){
						console.log(response);
						// Notify, Clear password form, and reset loader
		                 noty({
		                     text: 'Password has been changed',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
						context.form.fields.password = '';
						context.form.fields.password_confirmation = '';
						context.passwordIsChanging = false;
					})
					.catch(function(response){
						console.log(response);
					});
			}
			
		},

		// Retrieves all users from storage upon compenent mounting
		mounted(){
			this.getAndSetModels();
		}

	}
	
</script>