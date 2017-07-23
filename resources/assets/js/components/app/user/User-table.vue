<template>

<!-- Containing div -->
<div>
	<!-- Loader - shows if prop data is not yet populated -->
	<div v-if="isLoading" class="row margin-85-top margin-85-bottom">
		<div class="row row-padded">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<div v-if="!isLoading">
		<div class="row row-padded">
			<h2>User Details</h2>
		</div>

		<!-- Tool navigation -->
		<div class="row row-padded margin-25-top">
			<button @click="$router.push('options')" class="btn btn-default">
				<span class="glyphicon glyphicon-wrench"></span>&nbsp;Options
			</button>	
		</div>

		<!-- Basic info row 1 -->
		<div class="row row-padded margin-25-top">
			<h4>Basics</h4>
			<!-- Field column -->
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.first" class="panel-body">
						<h5><strong>First Name</strong></h5>
				    	<div v-if="user.first == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.first }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('first')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label"></label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="First name">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('first')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->
			<!-- Field column -->
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.last" class="panel-body">
						<h5><strong>Last Name</strong></h5>
				    	<div v-if="user.last == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.last }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('last')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label"></label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Last name">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('last')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->
			<!-- Field column -->
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.email" class="panel-body">
						<h5><strong>Email Address</strong></h5>
				    	<div v-if="user.email == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.email }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('email')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label"></label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Email address">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('email')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->								

		</div><!-- / Basic info row 1 -->

		<!-- Basic info row 2 -->
		<div class="row row-padded">
			<!-- Field column -->
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.permissions" class="panel-body">
						<h5><strong>Permissions</strong></h5>
				    	<div v-if="user.permissions == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.permissions }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('permissions')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Permissions</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
			                    	<option value="user">User</option>
			                        <option value="admin">Administrator</option>
			                    </select>
			                    <span v-if="editingField.err" class="text-danger" >{{ editingField.permissions.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('permissions')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->		
		</div><!-- / Basic info row 2 -->

		<!-- User business row -->
		<div class="row row-padded margin-25-top">
			<h4>Business</h4>
			<!-- Field column -->
			<div class="col-md-3">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.company_name" class="panel-body">
						<h5><strong>Company Name</strong></h5>
				    	<div v-if="user.company_name == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.company_name }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('company_name')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label">Company Name</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="company_name address">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('company_name')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->
			<!-- Field column -->
			<div class="col-md-3">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.gst_number" class="panel-body">
						<h5><strong>GST Number</strong></h5>
				    	<div v-if="user.gst_number == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.gst_number }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('gst_number')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label">GST Number</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="gst_number address">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('gst_number')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->							

			<!-- Field column -->
			<div class="col-md-3">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.hourly_rate_one" class="panel-body">
						<h5><strong>Hourly No. One</strong></h5>
				    	<div v-if="user.hourly_rate_one == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		${{ user.hourly_rate_one }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('hourly_rate_one')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="editingField.val" type="text" class="form-control" placeholder="0.00">
		                    	</div>
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('hourly_rate_one')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->
			<!-- Field column -->
			<div class="col-md-3">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div v-if="!fieldIsEditing.hourly_rate_two" class="panel-body">
						<h5><strong>Hourly No. 2</strong></h5>
				    	<div v-if="user.hourly_rate_two == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ user.hourly_rate_two }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('hourly_rate_two')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label">Hourly No. 2</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="editingField.val" type="text" class="form-control" placeholder="0.00">
		                    	</div>
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('hourly_rate_two')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="sendFieldUpdate" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div><!-- / Input form toggle panel -->					
				</div>
			</div><!-- / Field column -->

		</div><!-- / User business row -->
	</div><!-- Table wrapper -->
</div><!-- / Containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		props: ['user'],

		mixins: [api_access],

		data(){
			return{
				// Waiting for prop to be populated
				isLoading: false,
				// Used by API access
				fieldIsUpdating: false,
				// Used by API access
				editingField: {
					field: '', 
					val: '', 
					err: false
				},
				// Used by API access
				fieldIsEditing: {
					first: false,
					last: false,
					permissions: false,
					email: false,
					password: false,
					password_confirmation: false,
					company_name: false,
					hourly_rate_one: false,
					hourly_rate_two: false,
					gst_number: false						
				},
				form: {
					updateEvent: 'user-updated'
				}				
			}
		},

		watch:{
			// Wait for the user prop to be populated and then turn off loading
			user(){
				this.isLoading = false;
			}
		},

		methods: {
			// Shows the field input and hides the field table
			showEditField(field){
				// Set the field that shows the editing input
				this.fieldIsEditing[field] = true;
				// Set the values for the input
				this.editingField.field = field;
				this.editingField.val = this.user[field];
			},
			// Shows the field table and hides the field input
			closeEditingField(field){
				this.fieldIsEditing[field] = false;
			},
			// Update the field
			sendFieldUpdate(){
				// Use API access method to submit the change
				this.updateField('/api/users/update-field', this.user.id);
			}
		},

		created(){
			console.log('User table created');
			// Show loader if no user cached
			if(this.user.id == null){
				this.isLoading = true;
			}
		}		
	}

</script>