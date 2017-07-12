<template>
	
<!-- Component container  -->
<div>
	<div class="row row-padded">
		<h3>Project Timeline / Milestones</h3>
	</div>
	<!-- Tool navigation -->
	<div class="row row-padded margin-25-top">
		<button v-if="timeline" @click="$router.push('timeline-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-hourglass"></span> Edit Timeline
		</button>	
		<!-- Show the add timeline button if no timeline is yet present -->
		<button v-if="!timeline" @click="$router.push('timeline-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-hourglass"></span> Start Timeline
		</button>		
	</div>
	<!-- Show alert if no timeline in project -->
	<div v-if="!timeline">
		<div class="row row-padded margin-35-top">
			<div class="alert alert-warning text-center">
				<big><strong>Heads up!</strong> Timeline has not been started. Click the button above to begin</big>
			</div>				
		</div>
	</div>
	<!-- timeline table in the form of panels -->
	<div v-if="timeline">
		<div class="row row-padded margin-35-top">
		    <!-- Timeline -->
		    <div class="timeline">
		        <!-- Line component -->
		        <div class="line text-muted"></div>
		        <!-- Separator -->
		        <div class="separator text-muted"></div>
		        <!-- Panel -->
		        <article class="panel panel-info">	
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Permit Application Date</h2>
		            </div>
		            <!-- Show field table as default -->
		            <div v-if="!fieldIsEditing.permit_application_date" class="panel-body">
		                {{ timeline.permit_application_date }}
				    	<div class="pull-right">
				    		<span @click="showEditField('permit_application_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
		            </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
		                    <div class="col-md-4">
		                    	<label class="control-label"></label>
		                    	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
		                    	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
		                    </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('permit_application_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->	            
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"> </div>

		        <!-- Panel -->
		        <article class="panel panel-info">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Permit Recieved Date</h2>
		            </div><!-- /Heading -->

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.permit_recieved_date" class="panel-body">
				    	<div v-if="timeline.permit_recieved_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.permit_recieved_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('permit_recieved_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('permit_recieved_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-info">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Permit Number</h2>
		            </div><!-- /Heading -->		    
					<!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.permit_number" class="panel-body">
				    	<div v-if="timeline.permit_number == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
							{{ timeline.permit_number }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('permit_number')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Permit No.">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('permit_number')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-primary">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Site Numer Application Date</h2>
		            </div><!-- /Heading -->		    

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.site_number_application_date" class="panel-body">
				    	<div v-if="timeline.site_number_application_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.site_number_application_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('site_number_application_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('site_number_application_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-primary">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Site Numer Recieved Date</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.site_number_recieved_date" class="panel-body">
				    	<div v-if="timeline.site_number_recieved_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.site_number_recieved_date }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('site_number_recieved_date')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('site_number_recieved_date')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->		            	
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-primary">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Site Number</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.site_number" class="panel-body">
				    	<div v-if="timeline.site_number == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
							{{ timeline.permit_number }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('site_number')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<input v-model="editingField.val" type="text" class="form-control margin-10-top" placeholder="Site No.">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('site_number')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>
		    
		        <!-- Panel -->
		        <article class="panel panel-success">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Project Completion Target</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.completion_target" class="panel-body">
				    	<div v-if="timeline.completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.completion_target }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('completion_target')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('completion_target')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-success">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Fieldwork Completion Target</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.field_completion_target" class="panel-body">
				    	<div v-if="timeline.field_completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.field_completion_target }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('field_completion_target')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('field_completion_target')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-success">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Report Completion Target</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.report_completion_target" class="panel-body">
				    	<div v-if="timeline.report_completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.report_completion_target }}
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('report_completion_target')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
				            	<label class="control-label"></label>
				            	<input v-model="editingField.val" type="date" class="form-control margin-10-top">
				            	<span class="text-danger" v-if="editingField.err">{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('report_completion_target')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3 margin-20-top">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-default">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Fieldwork Scheduled</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.fieldwork_scheduled" class="panel-body">
				    	<div v-if="timeline.fieldwork_scheduled == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.fieldwork_scheduled == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('fieldwork_scheduled')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('fieldwork_scheduled')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-default">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Artiface Analysis Complete</h2>
		            </div><!-- /Heading -->		

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.artifact_analysis" class="panel-body">
				    	<div v-if="timeline.artifact_analysis == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.artifact_analysis == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('artifact_analysis')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('artifact_analysis')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-default">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Mapping Complete</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.mapping" class="panel-body">
				    	<div v-if="timeline.mapping == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.mapping == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('mapping')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('mapping')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-default">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Writing Complete</h2>
		            </div><!-- /Heading -->

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.writing" class="panel-body">
				    	<div v-if="timeline.writing == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.writing == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('writing')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('writing')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-danger">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Draft Submitted</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.draft_submitted" class="panel-body">
				    	<div v-if="timeline.draft_submitted == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.draft_submitted == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('draft_submitted')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('draft_submitted')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-danger">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Draft Accepted</h2>
		            </div><!-- /Heading -->		

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.draft_accepted" class="panel-body">
				    	<div v-if="timeline.draft_accepted == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.draft_accepted == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('draft_accepted')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('draft_accepted')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
			    </article><!-- /Panel -->

		        <!-- Separator -->
		        <div class="separator text-muted"></div>

		        <!-- Panel -->
		        <article class="panel panel-danger">
		            <!-- Icon -->
		            <div class="panel-heading icon">
		                <i class="glyphicon glyphicon-info-sign"></i>
		            </div><!-- /Icon -->		    
		            <!-- Heading -->
		            <div class="panel-heading">
		                <h2 class="panel-title">Final Approval</h2>
		            </div><!-- /Heading -->	

				    <!-- Show field table as default -->
				    <div v-if="!fieldIsEditing.final_approval" class="panel-body">
				    	<div v-if="timeline.final_approval == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
					    	<div v-if="timeline.final_approval == false">
					    		<span class="label label-warning">NO</span>
					    	</div>
					    	<div v-else>
					    		YES
					    	</div>
				    	</div>
				    	<div class="pull-right">
				    		<span @click="showEditField('final_approval')" class="glyphicon glyphicon-cog hover"></span>
				    	</div>		                
				    </div>
					<!-- Show input form if edit mode is toggled -->
					<div v-else class="panel-body">
						<div class="form-group">
				            <div class="col-md-4">
								<select v-model="editingField.val" class="form-control margin-10-top">
				                	<option value="0">No</option>
				                    <option value="1">Yes</option>
				                </select>
				                <span v-if="editingField.err" class="text-danger" >{{ editingField.err }}</span>
				            </div>
					    	<div class="pull-right">
					    		<span @click="closeEditingField('final_approval')" class="glyphicon glyphicon-remove hover"></span>
					    	</div>
							<div class="col-md-3">
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
					</div><!-- / Input form toggle panel -->
		        </article><!-- /Panel -->

		    </div>
		    <!-- /Timeline -->
		</div>

	</div><!-- / timeline table panels -->		
																		
</div><!-- / containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		// The timeline to populate the table with
		// The parent project id
		props: ['timeline', 'project_id'],

		mixins: [api_access],

		data(){
			return{
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
					permit_application_date: false,
					permit_recieved_date: false,
					permit_number: false,
					site_number_application_date: false,
					site_number_recieved_date: false,
					site_number: false,
					completion_target: false,		
					field_completion_target: false,
					report_completion_target: false,
					fieldwork_scheduled: false,
					artifact_analysis: false,
					mapping: false,
					writing: false,
					draft_submitted: false,
					draft_accepted: false,
					final_approval: false					
				}
			}
		},

		methods: {
			// Shows the field input and hides the field table
			showEditField(field){
				// Set the field that shows the editing input
				this.fieldIsEditing[field] = true;
				// Set the values for the input
				this.editingField.field = field;
				this.editingField.val = this.timeline[field];
			},
			// Shows the field table and hides the field input
			closeEditingField(field){
				this.fieldIsEditing[field] = false;
			},
			// Update the field
			sendFieldUpdate(){
				// Use API access method to submit the change
				this.updateField('/api/timelines/update-field', this.timeline.id);
			}
		},			

		created(){
			console.log('Timeline table created');
		}		
	}

</script>