<template>

<!-- Containing row -->
<div class="row margin-75-top">
	<div class="col-md-12">
		<!-- Panel -->
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Personal Settings</h3>
		    </div>
		    <!-- Panel body -->
		    <div class="panel-body">
				<div class="row margin-45-top">
					<div class="col-md-12">
						<!-- Well container for info form -->
						<div class="well bs-component">
							<!-- The info form -->
							<form class="form-horizontal"
								@submit.prevent
							>
								<fieldset class="margin-25-top">
									<legend>Your Info</legend>
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
								</fieldset>
								<!-- Button -->	
								<fieldset>
									<div class="row">
										<div class="col-md-3 col-centered">
											<div class="form-group">
												<button @click="updateInfo" class="btn btn-primary btn-block margin-45-top">
													<span v-if="!form.isUpdating">Update</span>
													<span v-if="form.isUpdating">
														<div class="center-loader"></div>
													</span>
												</button>												
											</div>					
										</div>
									</div>			
								</fieldset>									
							</form>	<!-- / info form -->
						</div><!-- / container for info form -->

						<!-- Well container for change password form -->
						<div class="well bs-component">
							<!-- Change password form -->
							<form class="form-horizontal"
								@submit.prevent
							>
								<fieldset class="margin-25-top">
									<legend>Change Password</legend>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" :class="{'has-error': form.fields.current_password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Current Password</label>
							                    	<input v-model="form.fields.current_password.val" type="password" class="form-control margin-10-top" placeholder="Current password">
							                    	<span class="text-danger" v-if="form.fields.current_password.err">{{ form.fields.current_password.err }}</span>
							                    </div>
						                  	</div>											
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" :class="{'has-error': form.fields.password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">New Password</label>
							                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="New password">
							                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.err }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" :class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm new password">
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
												<button v-on:click="changePassword" class="btn btn-primary btn-block margin-45-top">
													<span v-if="!form.passwordIsChanging">Change</span>
													<span v-if="form.passwordIsChanging">
														<div class="center-loader"></div>
													</span>
												</button>												
											</div>					
										</div>
									</div>			
								</fieldset>									
							</form><!-- / Change password form -->
						</div><!-- / container for change password form -->						

					</div>					
				</div><!-- / Row in panel body -->

		    </div><!-- / Panel body -->
		</div><!--/ Panel -->

	</div>
</div><!-- / Containing row -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		mixins: [api_access],

		data(){
			return{
				form:{
					isUpdating: false,
					passwordIsChanging: false,
					fields: {
						id: {val: '', err: '', dflt: ''},
						email: {val: '', err: '', dflt: ''},
						current_password: {val: '', err: '', dflt: ''},
						password: {val: '', err: '', dflt: ''},
						password_confirmation: {val: '', err: '', dflt: ''},
						company_name: {val: '', err: '', dflt: ''},
						gst_number: {val: '', err: '', dflt: ''}						
					}
				}				
			}
		},

		methods: {
			// Sets the default form values based on a User model
			populateDefaultFormValues(model){
				// Populate form
				this.form.fields.id.dflt = model.id;
				this.form.fields.email.dflt = model.email;
				this.form.fields.company_name.dflt = model.company_name;
				this.form.fields.gst_number.dflt = model.gst_number;				
			},

			// Updates the logged in users information
			updateInfo(){
				var context = this;
				// Show loader
				context.form.isUpdating = true;
				// Assemble object for POST
				var data = {
					email: this.form.fields.email.val,
					company_name: this.form.fields.company_name.val,
					gst_number: this.form.fields.gst_number.val,
					_token: window.Laravel.csrfToken
				};
				// Send POST to server
				axios.post('/api/update-user', data)
					.then(function(response){
						console.log(response);
						// Update form
						context.clearFormErrors();
						context.populateDefaultFormValues(response.data.model);
						context.populateFormFromModel(response.data.model);
						console.log(context.form);
						// Notify, Clear password form, and reset loader
		                 noty({
		                     text: 'Info has been updated',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
						context.form.isUpdating = false;
					})
					.catch(function(error){
                        if (error.response) {
                            // If the server responded with error data
                            for(var key in error.response.data){
                                context.form.fields[key].err = error.response.data[key][0];                                  
                            }
                            // Hide loader
                            context.form.isLoading = false;

                        }
					});
			},

			// Changes the logged in users password
			changePassword(){
				// Show loader
				this.form.passwordIsChanging = true;
				// Assemble object for POST
				var data = {
					current_password: this.form.fields.current_password.val,
					password: this.form.fields.password.val,
					password_confirmation: this.form.fields.password_confirmation.val,
					_token: window.Laravel.csrfToken
				};
				// Cache context
				var context = this;
				// Send POST to server
				axios.post('/api/change-personal-password', data)
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
		                 context.clearFormErrors();
		                context.clearForm();
						context.form.passwordIsChanging = false;
					})
					.catch(function(error){

						console.log(error.response);
                        if (error.response) {
                            // If the server responded with error data
                            for(var key in error.response.data){
                                context.form.fields[key].err = error.response.data[key][0];                                   
                            }
                            // Hide loader
                            context.form.passwordIsChanging = false;
                        }
					});				
			}
		},

		// Sets up the inital form with the logged in users data
		created(){
			var context = this;
			// Only the token
			var data = {
				_token: window.Laravel.csrfToken
			}
			// Using POST with token for security
			axios.post('/api/get-logged-in-user', data)
				.then(function(response){
					context.populateDefaultFormValues(response.data.model);
					context.populateFormFromModel(response.data.model);
				})
				.catch(function(error){
					console.log(error);
				});
		}
	}
	
</script>