<template>

<!-- Containing div -->
<div class="col-md-12">
	<div class="col-md-12">
		<h3>Project Proposal</h3>
	</div>

	<!-- Tool navigation -->
	<div class="col-md-12 margin-25-top">
		<button v-if="proposal" @click="$router.push('proposal-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-briefcase"></span> Edit Proposal
		</button>	
		<!-- Show the add proposal button if no proposal is yet present -->
		<button v-if="!proposal" @click="$router.push('proposal-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-briefcase"></span> Add Proposal
		</button>		
	</div>
	
	<!-- Show alert if no proposal in project -->
	<div v-if="!proposal">
		<div class="col-md-12 margin-35-top">
			<div class="alert alert-info">
				<strong>Heads up!</strong> Proposal has not yet been added. Click the button above to get started
			</div>				
		</div>
	</div>

	<!-- Proposal table in the form of panels -->
	<div v-if="proposal">
		<div class="col-md-12 margin-25-top">
			<h4>Work Details</h4>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Work Type</strong></h5>
				    	<div v-if="proposal.work_type == null">
				    		<span class="label label-warning">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ proposal.work_type }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Work Overview</strong></h5>
				    	<div v-if="proposal.work_overview == null">
				    		<span class="label label-warning">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ proposal.work_overview }}
				    	</div>									
					</div>
				</div>
			</div>	
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Work Plans</strong></h5>
				    	<div v-if="proposal.plans == null">
				    		<span class="label label-warning">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ proposal.plans }}
				    	</div>									
					</div>
				</div>
			</div>																	
		</div>	

		<div class="col-md-12 margin-25-top">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Estimate</strong></h5>
				    	<div v-if="proposal.estimate == null">
				    		<span class="label label-warning">N/A</span>
				    	</div>
				    	<div v-else>
				    		${{ proposal.estimate }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Response By</strong></h5>
				    	<div v-if="proposal.response_by == null">
				    		<span class="label label-warning">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ proposal.response_by }}
				    	</div>									
					</div>
				</div>
			</div>																		
		</div>	

		<div class="col-md-12 margin-25-top">
			<h4>Project Approval</h4>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5><strong>Approval Date</strong></h5>
				    	<div v-if="proposal.approval_date == null">
				    		<span class="label label-danger">Not yet approved</span>
				    	</div>
				    	<div v-else>
				    		{{ proposal.approval_date }}
				    	</div>									
					</div>
				</div>
			</div>																	
		</div>		
	</div><!-- / proposal table panels -->																				
</div><!-- / containing div -->

</template>

<script>
	export default{
		props: ['proposal', 'project_id']
	}
</script>