<template>
	
<div class="well bs-component">
	<form class="form-horizontal">
		<fieldset class="margin-25-top">
			<legend>{{ title }}</legend>
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.first.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">First Name</label>
	                    	<input v-model="form.first.val" type="text" class="form-control margin-10-top" placeholder="First">
	                    	<span v-if="form.first.err">{{ form.first.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.last.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Last Name</label>
	                    	<input v-model="form.last.val" type="text" class="form-control margin-10-top" placeholder="Last">
	                    	<span v-if="form.last.err">{{ form.last.msg }}</span>
	                    </div>
                  	</div>					
				</div>				
			</div>
		</fieldset>
		<fieldset>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.email.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Email (used as username)</label>
	                    	<input v-model="form.email.val" type="email" class="form-control margin-10-top" placeholder="Email address">
	                    	<span v-if="form.email.err">{{ form.email.msg }}</span>
	                    </div>
                  	</div>					
				</div>			
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.permissions.err}">
						<div class="col-lg-10">
							<label class="control-label">Permissions</label>
							<select v-model="form.permissions.val" class="form-control margin-10-top">
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
					<div class="form-group" v-bind:class="{'has-error': form.password.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Initial Password</label>
	                    	<input v-model="form.password.val" type="password" class="form-control margin-10-top" placeholder="Password">
	                    	<span v-if="form.password.err">{{ form.password.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.password_confirmation.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Confirm Password</label>
	                    	<input v-model="form.password_confirmation.val" type="password" class="form-control margin-10-top" placeholder="Confirm password">
	                    	<span v-if="form.password_confirmation.err">{{ form.password_confirmation.msg }}</span>
	                    </div>
                  	</div>					
				</div>												
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.company_name.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Company Name</label>
	                    	<input v-model="form.company_name.val" type="text" class="form-control margin-10-top" placeholder="Company name">
	                    	<span v-if="form.company_name.err">{{ form.company_name.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.gst_number.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">GST Number</label>
	                    	<input v-model="form.gst_number.val" type="text" class="form-control margin-10-top" placeholder="GST No.">
	                    	<span v-if="form.gst_number.err">{{ form.gst_number.msg }}</span>
	                    </div>
                  	</div>					
				</div>												
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.hourly_rate_one.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Hourly Rate One</label>
	                    	<div class="input-group margin-10-top">
	                    		<span class="input-group-addon">$</span>
	                    		<input v-model="form.hourly_rate_one.val" type="text" class="form-control" placeholder="Hourly rate one">
	                    	</div>	                    	
	                    	<span v-if="form.hourly_rate_one.err">{{ form.hourly_rate_one.msg }}</span>
	                    </div>
                  	</div>					
				</div>
				<div class="col-md-6">
					<div class="form-group" v-bind:class="{'has-error': form.hourly_rate_two.err}">
	                    <div class="col-lg-10">
	                    	<label class="control-label">Hourly Rate Two</label>
	                    	<div class="input-group margin-10-top">
	                    		<span class="input-group-addon">$</span>
	                    		<input v-model="form.hourly_rate_two.val" type="text" class="form-control" placeholder="Hourly rate two">
	                    	</div>
	                    	<span v-if="form.hourly_rate_two.err">{{ form.hourly_rate_two.msg }}</span>
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
					<button v-if="!isCreating" v-on:click="createUser" class="btn btn-primary btn-block margin-45-top">{{ button }}</button>
					<div v-if="isCreating" class="loader"></div>
				</div>					
			</div>
		</div>			
	</fieldset>
</div>

</template>

<script>
	
	export default {
		props: ['state', 'selectedUser'],

		data(){
			return {
				form: {
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
				},

				title: '',

				button: '',

				confirmPassword: '',

				passwordsMatch: false,

				isCreating: false

			}
		},

		methods: {

			// Clears the form to a blank slate ready for input
			clearForm(){
				for(var key in this.form){
					if(key == 'hourly_rate_one' || key == 'hourly_rate_two') this.form[key].val = '0.00';
						else this.form[key].val = '';
				}
			},

			// Sends a POST request to create a user
			createUser(){
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
				axios.post('/app/users/create', data)
					.then(function(response){
						console.log(response);
						// Clear form, notify, and reset loader
		                 noty({
		                     text: 'User has been created',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
						context.clearForm();
						context.isCreating = false;
						// Alert the parent to what just happened
						this.$emit('user-created', response.data.project);
					})
					.catch(function(response){

					});
			}

		},

		mounted(){
			console.log('mounted');
			// If a user has been passed to the component then add it to the form 'model'
			if(this.state == 'edit'){
				if(this.selectedUser != ''){
					for(var key in this.form){
						this.form[key].val = this.selectedUser[key];
					}

				}
				this.title = 'Edit User';
				this.button = 'Update';				
			} else {
				this.title = 'Create User';
				this.button = 'Save';
			}

		}
		
	}

</script>