<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Personal Settings</h3>
		    </div>
		    <div class="panel-body">
				<div class="row margin-45-top">
					<div class="col-md-12">
						<div class="well bs-component">
							<form v-on:submit.prevent="onSubmit" class="form-horizontal">
								<fieldset class="margin-25-top">
									<legend>Your Info</legend>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.email.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Email (used as username)</label>
							                    	<input v-model="form.fields.email.val" type="email" class="form-control margin-10-top" placeholder="Email address">
							                    	<span class="text-danger" v-if="form.fields.email.err">{{ form.fields.email.msg }}</span>
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
							                    	<span class="text-danger" v-if="form.fields.company_name.err">{{ form.fields.company_name.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.gst_number.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">GST Number</label>
							                    	<input v-model="form.fields.gst_number.val" type="text" class="form-control margin-10-top" placeholder="GST No.">
							                    	<span class="text-danger" v-if="form.fields.gst_number.err">{{ form.fields.gst_number.msg }}</span>
							                    </div>
						                  	</div>					
										</div>												
									</div>									
								</fieldset>	
								<fieldset>
									<div class="row">
										<div class="col-md-3 col-centered">
											<div class="form-group">
												<button v-on:click="updateInfo" class="btn btn-primary btn-block margin-45-top">
													<span v-if="!form.isUpdating">Update</span>
													<span v-if="form.isUpdating">
														<div class="center-loader"></div>
													</span>
												</button>												
											</div>					
										</div>
									</div>			
								</fieldset>									
							</form>	
						</div>

						<div class="well bs-component">
							<form v-on:submit.prevent="onSubmit" class="form-horizontal">
								<legend>Change Password</legend>
								<fieldset class="margin-25-top">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.current_password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Current Password</label>
							                    	<input v-model="form.fields.current_password.val" type="password" class="form-control margin-10-top" placeholder="Current password">
							                    	<span class="text-danger" v-if="form.fields.current_password.err">{{ form.fields.current_password.msg }}</span>
							                    </div>
						                  	</div>											
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">New Password</label>
							                    	<input v-model="form.fields.password.val" type="password" class="form-control margin-10-top" placeholder="New password">
							                    	<span class="text-danger" v-if="form.fields.password.err">{{ form.fields.password.msg }}</span>
							                    </div>
						                  	</div>					
										</div>
										<div class="col-md-6">
											<div class="form-group" v-bind:class="{'has-error': form.fields.password_confirmation.err}">
							                    <div class="col-lg-10">
							                    	<label class="control-label">Confirm Password</label>
							                    	<input v-model="form.fields.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm new password">
							                    	<span class="text-danger" v-if="form.fields.password_confirmation.err">{{ form.fields.password_confirmation.msg }}</span>
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
							</form>	
						</div>						

					</div>					
				</div>

		    </div>
		</div>		
	</div>
</div>

</template>

<script>

	export default{
		data(){
			return{
				form:{
					isUpdating: false,
					passwordIsChanging: false,
					fields: {
						id: {val: DASHBOARD_USER_ID, err: '', msg: ''},
						email: {val: DASHBOARD_USER_EMAIL, err: '', msg: ''},
						current_password: {val: '', err: '', msg: ''},
						password: {val: '', err: '', msg: ''},
						password_confirmation: {val: '', err: '', msg: ''},
						company_name: {val: DASHBOARD_USER_COMPANY, err: '', msg: ''},
						gst_number: {val: DASHBOARD_USER_GST, err: '', msg: ''}						
					}
				}				
			}
		},

		methods: {
			// Clears the user form to a blank slate ready for input
			clearForm(){
				for(var key in this.form.fields){
					if(key == 'current_password' || key == 'password' || key == 'password_confirmation'){
						this.form.fields[key].val = '';
					}					
				}
				// Clear errors
				this.clearFormErrrors();
			},

			// Clears out any potential error state the inputs are in
			clearFormErrrors(){
				for(var key in this.form.fields){
					// Clear possible errors
					this.form.fields[key].err = false;
					this.form.fields[key].msg = '';
				}
			},

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
				axios.post('/app/update-user', data)
					.then(function(response){
						console.log(response);
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
					.catch(function(response){
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
				axios.post('/app/change-personal-password', data)
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
		                context.clearForm();
						context.form.passwordIsChanging = false;
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
                            context.form.passwordIsChanging = false;
                        }
					});				
			}
		}
	}
	
</script>