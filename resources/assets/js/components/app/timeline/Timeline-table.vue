<template>
	
<!-- Component container  -->
<div class="col-md-12">

	<div class="col-md-12">
		<h3>Project Timeline / Milestones</h3>
	</div>
	<!-- Tool navigation -->
	<div class="col-md-12 margin-25-top">
		<button v-if="timeline" @click="$router.push('timeline-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-briefcase"></span> Edit Timeline
		</button>	
		<!-- Show the add timeline button if no timeline is yet present -->
		<button v-if="!timeline" @click="$router.push('timeline-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-briefcase"></span> Start Timeline
		</button>		
	</div>
	<!-- Show alert if no timeline in project -->
	<div v-if="!timeline">
		<div class="col-md-12 margin-35-top">
			<div class="alert alert-info">
				<strong>Heads up!</strong> Timeline has not yet been added. Click the button above to get started
			</div>				
		</div>
	</div>
	<!-- timeline table in the form of panels -->
	<div v-if="timeline">
		<div class="col-md-12 margin-35-top">
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
		            </div><!-- /Heading -->
		            <!-- Body -->
		            <div class="panel-body">
		                {{ timeline.permit_application_date }}
		            </div> <!-- /Body -->
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div><!-- /Footer -->
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.permit_recieved_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.permit_recieved_date }}
				    	</div>
		            </div><!-- /Body -->
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div><!-- /Footer -->
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.permit_number == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.permit_number }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.site_number_application_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.site_number_application_date }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.site_number_recieved_date == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.site_number_recieved_date }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		                <h2 class="panel-title">Site Numer</h2>
		            </div><!-- /Heading -->		    
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.site_number == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.site_number }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.completion_target }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.field_completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.field_completion_target }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.report_completion_target == null">
				    		<span class="label label-warning">MILESTONE NOT COMPLETE</span>
				    	</div>
				    	<div v-else>
				    		{{ timeline.report_completion_target }}
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.fieldwork_scheduled == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.artifact_analysis == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.mapping == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.writing == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.draft_submitted == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.draft_accepted == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
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
		            <!-- Body -->
		            <div class="panel-body">
				    	<div v-if="timeline.final_approval == false">
				    		<span class="label label-warning">NO</span>
				    	</div>
				    	<div v-else>
				    		YES
				    	</div>
		            </div><!-- /Body -->		    
		            <!-- Footer -->
		            <div class="panel-footer">
		            </div>
		        </article><!-- /Panel -->

		    </div>
		    <!-- /Timeline -->
		</div>

	</div><!-- / timeline table panels -->		
																		
</div><!-- / containing div -->

</template>

<script>
	
	export default{
		// The timeline to populate the table with
		// The parent project id
		props: ['timeline', 'project_id'],

		created(){
			console.log('Timeline table created');
		}		
	}

</script>