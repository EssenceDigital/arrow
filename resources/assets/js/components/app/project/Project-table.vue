<template>
	
<!-- Component container -->
<div>
	<!-- Loader - shows if prop data is not yet populated -->
	<div v-if="isLoading" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<!-- Table wrapper - only shows after prop data is populated -->
	<div v-if="!isLoading">
		<div class="row row-padded">
			<h2>Project Details</h2>
		</div>

		<div class="row row-padded margin-25-top">
			<h3>Client</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.client_company_name" class="panel-body">
						<h5><strong>Client Company</strong></h5>
				    	<div v-if="project.client_company_name == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.client_company_name }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('client_company_name')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>									
					</div>
					<div v-else class="panel-body">
						<div class="form-group">
							<div class="col-md-11">
								<label class="control-label">Client company</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="" selected>Select existing client...</option>
									<option v-for="client in clients" 
										:value="client"
									>
										{{ client }}
									</option>
			                    </select>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('client_company_name')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>							
						</div>
						<div class="row row-padded">
							<div class="col-md-11">
								<div class="form-group">
									<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
										<span v-if="!fieldIsUpdating">Save</span>
										<span v-if="fieldIsUpdating">
											<div class="center-loader"></div>
										</span>
									</button>												
								</div>					
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<div class="row row-padded">
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.client_contact_name" class="panel-body">
						<h5><strong>Company Contact</strong></h5>
				    	<div v-if="project.client_contact_name == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.client_contact_name }}
				    	</div>	
				    	<div class="pull-right">
				    		<span @click="showEditField('client_contact_name')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-11">
		                    	<label class="control-label">Client Contact</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Name of contact">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('client_contact_name')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div>					
				</div>
			</div>								
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.client_contact_phone" class="panel-body">
						<h5><strong>Contact's Phone No.</strong></h5>
				    	<div v-if="project.client_contact_phone == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		<a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a>
				    	</div>	
				    	<div class="pull-right">
				    		<span @click="showEditField('client_contact_phone')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
		                    <div class="col-md-11">
		                    	<label class="control-label">Contact's Phone No.</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Contact phone number">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('client_contact_phone')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>		
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    	                    
	                  	</div>						
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.client_contact_email" class="panel-body">
						<h5><strong>Contact's Email</strong></h5>
				    	<div v-if="project.client_contact_email == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.client_contact_email }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('client_contact_email')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
		                    <div class="col-md-11">
		                    	<label class="control-label">Contact's Email</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Contact email">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('client_contact_email')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    		                    
	                  	</div>						
					</div>					
				</div>
			</div>
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<!-- Project table in the form of panels -->
		<div class="row row-padded margin-25-top">
			<h3>Location</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.province" class="panel-body">
						<h5><strong>Province</strong></h5>
				    	<div v-if="project.province == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.province }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('province')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Province</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
			                    	<option value="Alberta">Alberta</option>
			                        <option value="British Columbia">British Columbia</option>
			                        <option value="Saskatchewan">Saskatchewan</option>
			                    </select>
			                    <span v-if="editingField.err" class="text-danger" >{{ editingField.province.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('province')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>						
					</div>					
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-white post panel-shadow">									
					<div v-if="!fieldIsEditing.location" class="panel-body">
						<h5><strong>Specific Location</strong></h5>
				    	<div v-if="project.location == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.location }}
				    	</div>	
				    	<div class="pull-right">
				    		<span @click="showEditField('location')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>					    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
			                <div class="col-md-11">
			                	<label class="control-label">Specific Location</label>
			                    <textarea v-model="editingField.val" class="form-control margin-10-top" rows="3" placeholder="Specific location"></textarea>
			                    <span v-if="editingField.err" class="text-danger">{{ editingField.err }}</span>
			                </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('location')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    				                
			            </div>						
					</div>					
				</div>
			</div>	
		</div>
		<div class="row row-padded">							
			<div class="col-md-12">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.details" class="panel-body">
						<h5><strong>Basic Details</strong></h5>
				    	<div v-if="project.details == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.details }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('details')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
			                <div class="col-md-11">
			                	<label class="control-label">Basic Details</label>
			                    <textarea v-model="editingField.val" class="form-control margin-10-top" rows="3" placeholder="Project details"></textarea>
			                    <span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
			                </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('details')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    				                
			            </div>						
					</div>					
				</div>
			</div>
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h3>Work Details</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.work_type" class="panel-body">
						<h5><strong>Work Type</strong></h5>
				    	<div v-if="project.work_type == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.work_type }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('work_type')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Work Type</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
			                    	<option value="HRIA">HRIA</option>
			                        <option value="Archaeology">Archaeology</option>
			                        <option value="Palaeontology">Palaeontology</option>
			                    </select>
			                    <span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('work_type')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>						
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.response_by" class="panel-body">
						<h5><strong>Respond By</strong></h5>
				    	<div v-if="project.response_by == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.response_by }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('response_by')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
		                    <div class="col-md-11">
		                    	<label class="control-label">Respond By</label>
		                    	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('response_by')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    			                    
	                  	</div>						
					</div>					
				</div>
			</div>																			
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.estimate" class="panel-body">
						<h5><strong>Estimate</strong></h5>
				    	<div v-if="project.estimate == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		${{ project.estimate }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('estimate')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
		                    <div class="col-md-11">
		                    	<label class="control-label">Estimate</label>
		                    	<div class="input-group margin-10-top">
		                    		<span class="input-group-addon">$</span>
		                    		<input v-model="editingField.val" type="text" class="form-control">
		                    	</div>	                    	
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('estimate')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    		                    
	                  	</div>					
					</div>					
				</div>
			</div>			
		</div>
		<div class="row row-padded">
			<div class="col-md-12">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.work_overview" class="panel-body">
						<h5><strong>Work Overview</strong></h5>
				    	<div v-if="project.work_overview == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.work_overview }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('work_overview')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Work Overview</label>
								<textarea v-model="editingField.val" class="form-control margin-10-top" rows="3" placeholder="Overview of work"></textarea>
			                    <span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('work_overview')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>
		</div>
		<div class="row row-padded">
			<div class="col-md-12">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.plans" class="panel-body">
						<h5><strong>Work Plans</strong></h5>
				    	<div v-if="project.plans == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.plans }}
				    	</div>	
				    	<div class="pull-right">
				    		<span @click="showEditField('plans')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    									
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Work Plans</label>
								<textarea v-model="editingField.val" class="form-control margin-10-top" rows="3" placeholder="Work plans"></textarea>
			                    <span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('plans')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>
		</div>

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h3>Land</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.land_ownership" class="panel-body">
						<h5><strong>Land Ownership</strong></h5>
				    	<div v-if="project.land_ownership == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.land_ownership }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('land_ownership')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Land Ownership</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
			                    	<option>Crown</option>
			                        <option>Freehold</option>
			                    </select>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('land_ownership')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    							
						</div>					
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.land_access_granted" class="panel-body">
						<h5><strong>Is Access Granted?</strong></h5>
						<div class="col-md-11">
					    	<div v-if="project.land_access_granted == 0">No</div>
					    	<div v-if="project.land_access_granted == 1">Yes</div>
					    </div>
				    	<div class="pull-right">
				    		<span @click="showEditField('land_access_granted')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>					    
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Land Access Granted?</label>
								<select v-model="editingField.val" class="form-control margin-10-top">
									<option value="0">No</option>
			                    	<option value="1">Yes</option>
			                    </select>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('land_access_granted')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    							
						</div>					
					</div>					
				</div>
			</div>
		</div>
		<div class="row row-padded">								
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.land_access_granted_by" class="panel-body">
						<h5><strong>Access Granted By</strong></h5>
				    	<div v-if="project.land_access_granted_by == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.land_access_granted_by }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('land_access_granted_by')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Access Granted By</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Access granted by">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('land_access_granted_by')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.land_access_contact" class="panel-body">
						<h5><strong>Access Contact</strong></h5>
				    	<div v-if="project.land_access_contact == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.land_access_contact }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('land_access_contact')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Access Contact</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Access contact name">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('land_access_contact')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    							
						</div>					
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.land_access_phone" class="panel-body">
						<h5><strong>Contact's Phone</strong></h5>
				    	<div v-if="project.land_access_phone == null" class="col-md-11">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.land_access_phone }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('land_access_phone')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Contact's Phone</label>
		                    	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Contact's phone no.">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('land_access_phone')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>			
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h3>Invoicing</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.invoiced_date"  class="panel-body">
						<h5><strong>Invoiced Date</strong></h5>
				    	<div v-if="project.invoiced_date == null" class="col-md-11">
				    		<span class="label label-danger">Not Invoiced</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.invoiced_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('invoiced_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>					    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Invoiced Date</label>
		                    	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('invoiced_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">									
					<div v-if="!fieldIsEditing.invoice_paid_date" class="panel-body">
						<h5><strong>Invoice Paid On</strong></h5>
				    	<div v-if="project.invoice_paid_date == null" class="col-md-11">
				    		<span class="label label-danger">Not Invoiced</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.invoice_paid_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('invoice_paid_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    											
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Invoiced Paid On</label>
		                    	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('invoice_paid_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>	
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    							
						</div>					
					</div>					
				</div>
			</div>								
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h3>Project Approval</h3>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div v-if="!fieldIsEditing.approval_date" class="panel-body">
						<h5><strong>Project Approved On</strong></h5>
				    	<div v-if="project.approval_date == null" class="col-md-11">
				    		<span class="label label-danger">Not yet approved</span>
				    	</div>
				    	<div v-else class="col-md-11">
				    		{{ project.approval_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('approval_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>				    										
					</div>
					<div v-else class="panel-body">
						<div class="form-group" :class="{'has-error': editingField.err}">
							<div class="col-md-11">
								<label class="control-label">Project Approved On</label>
		                    	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
							</div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('approval_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="row row-padded">
								<div class="col-md-11">
									<div class="form-group">
										<button @click="submitUpdatedField" class="btn btn-primary btn-block margin-10-top">
											<span v-if="!fieldIsUpdating">Save</span>
											<span v-if="fieldIsUpdating">
												<div class="center-loader"></div>
											</span>
										</button>												
									</div>					
								</div>
							</div>					    								
						</div>					
					</div>					
				</div>
			</div>																	
		</div><!-- / padded row -->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<div class="col-md-12">
				<comment-list
					:comments="project.comments"
				>
				</comment-list>
			</div>
		</div>

		<div class="row row-padded margin-15-top">
		    <div class="col-md-12">
		        <div class="panel panel-white post panel-shadow">
		            <div class="post-description"> 
						<comment-form
							:model="'ProjectComment'"
							:urlPortion="'projects'"
							:project_id="project.id"
						>				
						</comment-form>	
		            </div>
		        </div>
		    </div>		
		</div>

	</div><!-- Table wrapper -->


</div><!-- / Component container -->

</template>

<script>
	let comment_form = require('./../comment/Comment-form.vue');
	let comment_list = require('./../comment/Comment-list.vue');
	

	export default{
		components: {
			'comment-form': comment_form,
			'comment-list': comment_list
		},		

		// The data to populated 'table' with
		props: ['project'],

		data(){
			return{
				// Waiting for prop to be populated
				isLoading: false,
				modalActive: false,
				clients: [],
				fieldIsUpdating: false,
				editingField: {
					field: '', 
					val: '', 
					err: false
				},
				fieldIsEditing: {
					province: false,
					location: false,
					details: false,
					client_company_name: false,
					client_contact_name: false,
					client_contact_phone: false,
					client_contact_email: false,
					first_contact_by: false,
					first_contact_date: false,
					land_ownership: false,
					land_access_granted: false,
					land_access_granted_by: false,
					land_access_contact: false,
					land_access_phone: false,
					invoiced_date: false,
					invoice_paid_date: false,
					// "Proposal" related fields
					plans: false,
					work_type: false,
					work_overview: false,
					response_by: false,
					estimate: false,
					approval_date: false					
				}			
			}
		},

		watch:{
			// Wait for the project prop to be populated and then turn off loading
			project(){
				this.isLoading = false;
			}
		},

		methods:{
			showEditField(field){
				// Set the field that shows the editing input
				this.fieldIsEditing[field] = true;
				// Set the values for the input
				this.editingField.field = field;
				this.editingField.val = this.project[field];
				
			},

			closeEditingField(field){
				this.fieldIsEditing[field] = false;
			},

			submitUpdatedField(){
				// Show loader
				this.fieldIsUpdating = true;
				// Cache needed data
				var context = this,
					postData = {
						project_id: this.project.id,
						_token: window.Laravel.csrfToken						
					};
				// Add updated field and data
				postData.field = this.editingField.field;
				postData[this.editingField.field] = this.editingField.val;

				console.log(postData);

				axios.post('/api/projects/update-field', postData)
					.then(function(response){
						// Let parent know it should update the project model
						context.$router.app.$emit('model-updated', response.data.model);
						// Hide loader
						context.fieldIsUpdating = false;
						// Hide form field
						context.fieldIsEditing[context.editingField.field] = false;
						// Notify success
		                 noty({
		                     text: 'Update was successful',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 1200,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
					})
					.catch(function(error){
	                    if (error.response) {
	                        // If the server responded with error data
	                        this.editingField.err = error.response.data[key][0];                              
	                    }
					});

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

		created(){
			console.log('Project table created');
			// Show loader if no project cached
			if(this.project.id == null){
				this.isLoading = true;
			}

			// Get unique clients from api
			this.getAndSetUniqueClients();
		}
	}

</script>