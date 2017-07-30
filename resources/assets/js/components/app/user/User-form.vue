<template>

<!-- Containing div -->
<div>
	<!-- Loader - shows if data is fetching -->
	<div v-if="formIsLoading" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<!-- Contains edit and delete forms - only shows after loading -->
	<div v-if="!formIsLoading">
		<!-- Create / edit user form container -->
		<div v-if="form.state == 'create'" class="well bs-component margin-25-top">
			<form class="form-horizontal"
				@submit.prevent
			>
				<fieldset class="margin-25-top">
					<legend>
						{{ form.title }}
						<button 
							@click="$router.go(-1)" 
							class="pull-right btn btn-danger"
						>
							&times;
						</button>					
					</legend>
					<div class="row">			
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.first.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">First Name</label>
			                    	<input v-model="form.fields.first.val" type="text" class="form-control margin-10-top" placeholder="First">
			                    	<span class="text-danger" v-if="form.fields.first.err">{{ form.fields.first.err }}</span>
			                    </div>
		                  	</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.last.err}">
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
							<div class="form-group" :class="{'has-error': form.fields.email.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Email (used as username)</label>
			                    	<input v-model="form.fields.email.val" type="email" class="form-control margin-10-top" placeholder="Email address">
			                    	<span class="text-danger" v-if="form.fields.email.err">{{ form.fields.email.err }}</span>
			                    </div>
		                  	</div>					
						</div>			
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.permissions.err}">
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
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.password.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Initial Password</label>
			                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="Password">
			                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.err }}</span>
			                    </div>
		                  	</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.password_confirmation.err}">
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
							<div class="form-group" :class="{'has-error': form.fields.company_name.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Company Name</label>
			                    	<input v-model="form.fields.company_name.val" type="text" class="form-control margin-10-top" placeholder="Company name">
			                    	<span class="text-danger" v-if="form.fields.company_name.err">{{ form.fields.company_name.err }}</span>
			                    </div>
		                  	</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.gst_number.err}">
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
							<div class="form-group" :class="{'has-error': form.fields.hourly_rate_one.err}">
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
							<div class="form-group" :class="{'has-error': form.fields.hourly_rate_two.err}">
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
		</div><!-- / Create / edit user form container -->

		<!-- Change password form container -->
		<div v-if="form.state == 'edit'" class="well bs-component">
			<!-- The form -->
			<form class="form-horizontal"
				@submit.prevent
			>
				<legend>
					Change Password
					<button 
						slot="close"
						@click="$router.push('/users/view/'+form.fields.id.val+'/hub')" 
						class="pull-right btn btn-danger"
					>
						&times;
					</button>					
				</legend>
				<fieldset class="margin-25-top">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.password.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">New Password</label>
			                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="Password">
			                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.err }}</span>
			                    </div>
		                  	</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': form.fields.password_confirmation.err}">
			                    <div class="col-lg-10">
			                    	<label class="control-label">Confirm Password</label>
			                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
			                    	<span class="text-danger" v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.err }}</span>
			                    </div>
		                  	</div>					
						</div>												
					</div>						
				</fieldset>	
				<fieldset>
					<div class="row">
						<div class="col-md-3 col-centered">
							<div class="form-group">
								<button v-on:click="changePassword" class="btn btn-info btn-block margin-45-top">
									<span v-if="!passwordIsChanging">Change</span>
									<span v-if="passwordIsChanging">
										<div class="center-loader"></div>
									</span>
								</button>
								
							</div>					
						</div>
					</div>			
				</fieldset>										
			</form><!-- / The form -->
		</div><!-- / Change password form container -->

		<!-- Container for delete button (triggers the modal below to confirm)
		<div v-if="form.state == 'edit'" class="well bs-component">
			<legend class="danger">
				Delete User							
			</legend>
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
		<modal 
			:modalActive="modalActive" 
			@modal-close="modalActive = false"
		>
			<h4 slot="title" class="danger">
				Delete this user?
			</h4>
			<p slot="body">
				Delete this user until the age that gave it birth comes again?
			</p>
			<div slot="footer">
				<button @click="modalActive = false" class="btn btn-info margin-45-top">Cancel</button>
				<button @click="deleteUser" class="btn btn-danger margin-45-top">
					<span v-if="!isDeleting">Delete</span>
					<span v-if="isDeleting">
						<div class="loader-center"></div>
					</span>
				</button>
			</div>
		</modal>/ Modal to confirm deletion -->	

	</div><!-- / Form wrapper -->

</div><!-- / Containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');
	let modal = require('./../_ui/Modal.vue');

	export default{
		components: {
			'modal': modal
		},

		props: ['user_id'],

		mixins: [api_access],

		data(){
			return {
				formIsLoading: false,
				modalActive: false,
				urlToDelete: '/api/users/delete',
				isDeleting: false,
				passwordIsChanging: false,				
				form:{
					model: 'User',
					state: 'create',
					title: 'Create User',
					button: 'Save',
					action: '/api/users/create',
					createAction: '/api/users/create',
					updateAction: '/api/users/update',	
					createEvent: 'user-created',
					updateEvent: 'user-updated',
					deleteEvent: 'user-deleted',				
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
				}				
			}
		},

		methods: {
			// Submits the form to server via mixin
			sendForm(){
				this.createOrUpdate();
			},

			// Submits a delete to server via mixin
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
				axios.post('/api/users/change-password', data)
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
						context.$router.push('/users/view/'+context.user_id+'/hub');
					})
					.catch(function(response){
						console.log(response);
					});
			}			
		},

		// If an id is in the route then retrieve the model from server
		created(){
			console.log('User form created');

			if(this.user_id){
				this.form.fields.id.val = this.user_id;
				// Adjust form state
				this.formEditState('edit');			
			}
		}		
	}
</script>