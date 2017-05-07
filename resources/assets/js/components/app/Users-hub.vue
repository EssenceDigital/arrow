<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Users Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="showAllUsersTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'user-form' }"><a v-on:click="showUserFormTab">{{ form.title }}</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div class="col-md-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="info">
									<th>Name</th>
									<th>Email</th>
									<th>Permissions</th>
									<th>Actions</th>
								</tr>
							</thead>
						  <tbody>
							    <tr v-for="user in users" v-bind:user="user">
								    <td>{{ user.first + ' ' + user.last }}</td>
								    <td>{{ user.email }}</td>
								    <td>{{ user.permissions }}</td>
								    <td>
								    	<dropdown v-bind:dropdownActive="dropdownActive">
								    		<li><a v-on:click="editUser(user.id)">Edit</a></li>
											<li class="divider"></li>
											<li><a href="#">Delete</a></li>
								    	</dropdown>
								    </td>
							    </tr>
						  </tbody>
						</table> 						
					</div>					
				</div>

				<div v-if="currentTab == 'user-form'" class="row margin-45-top">
					<div class="col-md-12">

						<div class="well bs-component">
							<form v-on:submit.prevent="onSubmit" class="form-horizontal">
								<fieldset class="margin-25-top">
									<legend>{{ form.title }}</legend>
									<div class="row">			
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.first.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">First Name</label>
							                    	<input v-model="form.fields.first.val" type="text" class="form-control margin-10-top" placeholder="First">
							                    	<span v-if="form.fields.first.err">{{ form.fields.first.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.last.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Last Name</label>
							                    	<input v-model="form.fields.last.val" type="text" class="form-control margin-10-top" placeholder="Last">
							                    	<span v-if="form.fields.last.err">{{ form.fields.last.msg }}</span>
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
							                    	<span v-if="form.fields.email.err">{{ form.fields.email.msg }}</span>
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
							                    	<span v-if="form.fields.password.err">{{ form.fields.password.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
							                    	<span v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.msg }}</span>
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
							                    	<span v-if="form.fields.company_name.err">{{ form.fields.company_name.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.gst_number.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">GST Number</label>
							                    	<input v-model="form.fields.gst_number.val" type="text" class="form-control margin-10-top" placeholder="GST No.">
							                    	<span v-if="form.fields.gst_number.err">{{ form.fields.gst_number.msg }}</span>
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
							                    	<span v-if="form.fields.hourly_rate_one.err">{{ form.fields.hourly_rate_one.msg }}</span>
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
							                    	<span v-if="form.fields.hourly_rate_two.err">{{ form.fields.hourly_rate_two.msg }}</span>
							                    </div>
						                  	</div>						
										</div>												
									</div>						
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-md-3 col-centered">
											<div class="form-group">
												<button v-if="!form.isLoading" v-on:click="sendForm" class="btn btn-primary btn-block margin-45-top">{{ form.button }}</button>
												<div v-if="form.isLoading" class="loader"></div>
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
							                    	<span v-if="form.fields.password.err">{{ form.fields.password.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
							                    	<span v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.msg }}</span>
							                    </div>
						                  	</div>					
										</div>												
									</div>						
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-md-3 col-centered">
											<div class="form-group">
												<button v-if="!passwordIsChanging" v-on:click="changePassword" class="btn btn-primary btn-block margin-45-top">Change</button>
												<div v-if="passwordIsChanging" class="loader"></div>
											</div>					
										</div>
									</div>			
								</fieldset>								
							</form>	
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
								<button v-if="!userIsDeleting" v-on:click="deleteUser" class="btn btn-danger margin-45-top">Delete</button>
								<div v-if="userIsDeleting" class="loader pull-right"></div>
							</div>
						</modal>												

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

	export default{
		components: {
			'modal': modal,
			'dropdown': dropdown
		},

		data(){
			return {
				currentTab: 'view-all',
				modalActive: false,
				dropdownActive: false,
				users: [],
				form:{
					state: 'create',
					title: 'Create User',
					button: 'Save',
					action: '/app/users/create',
					isLoading: false,
					fields: {
						id: {val: '', err: '', msg: ''},
						first: {val: '', err: '', msg: ''},
						last: {val: '', err: '', msg: ''},
						permissions: {val: '', err: '', msg: ''},
						email: {val: '', err: '', msg: ''},
						password: {val: '', err: '', msg: ''},
						password_confirmation: {val: '', err: '', msg: ''},
						company_name: {val: '', err: '', msg: ''},
						hourly_rate_one: {val: '0.00', err: '', msg: ''},
						hourly_rate_two: {val: '0.00', err: '', msg: ''},
						gst_number: {val: '', err: '', msg: ''}						
					}
				},
				passwordIsChanging: false,
				userIsDeleting: false
			}
		},

		methods: {

			// Clears the user form to a blank slate ready for input
			clearForm(){
				for(var key in this.form.fields){
					if(key == 'hourly_rate_one' || key == 'hourly_rate_two') this.form.fields[key].val = '0.00';
						else this.form.fields[key].val = '';
				}
				// Reset titles
				this.formNewState();
			},

			// Sets the form titles for a create
			formNewState(){
				this.form.state = 'create';
				this.form.title = 'Create User';
				this.form.button = 'Save';
				this.form.action = '/app/users/create';
			},

			// Sets the form titles for an edit
			formEditState(){
				this.form.state = 'edit';
				this.form.title = 'Edit User';
				this.form.button = 'Update';
				this.form.action = '/app/users/update';
			},

			showAllUsersTab(){
				this.currentTab = 'view-all';
				this.clearForm();
				this.getAndSetUsers();
			},

			showUserFormTab(){
				this.clearForm();
				this.currentTab = 'user-form';
			},

			closeEditUserModal(){
				this.modalActive = false;
				this.dropdownActive = false;
			},

			// Sends a GET request to retrieve all users from the server then sets the users data prop
			getAndSetUsers(){
				var context = this;
				// Send request
				axios.get('/app/users/all')
					.then(function(response){
						// Set data prop
						context.users = response.data.users;
						console.log(context.users);
					})
					.catch(function(response){
						console.log(response);
					});					
			},

			// Sends a POST request to create a user
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
				console.log(data);
				// Send POST to server
				axios.post(context.form.action, data)
					.then(function(response){
						console.log(response);
						// Clear form, notify, and reset loader
		                 noty({
		                     text: 'User has been saved',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
						context.form.isLoading = false;
					})
					.catch(function(response){

					});
			},

			editUser(id){
				var context = this;

				// Send request
				axios.get('/app/users/' + id)
					.then(function(response){
						// Set data prop
						for(var key in context.form.fields){
							context.form.fields[key].val = response.data.user[key];
						}
						// Adjust some text
						context.formEditState();
						// Change tab
						context.currentTab = 'user-form';

						console.log(context.form.fields.id.val);
					})
					.catch(function(response){
						console.log(response);
					});	
			},

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

					});
			},

			// Sends a POST request to delete the specified and confirmed user
			deleteUser(){
				// Show loader
				this.userIsDeleting = true;
				// Assemble object for POST
				var data = {
					id: this.form.fields.id.val,
					_token: window.Laravel.csrfToken
				};
				// Store context
				var context = this;
				// Send GET request to delete
				axios.post('/app/users/delete', data)
					.then(function(response){
						context.userIsDeleting = false;
						context.showAllUsersTab();
					})
					.catch(function(response){
						console.log(response);
					});				
			}			
		},



		mounted(){
			this.getAndSetUsers();
		}

	}
	
</script>