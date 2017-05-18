<template>

<div>
	<h3>Project Details</h3>

	<div class="col-md-12 margin-25-top">
		<h4>Location</h4>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Province</strong></h5>
			    	<div v-if="project.province == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.province }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">									
				<div class="panel-body">
					<h5><strong>Location</strong></h5>
			    	<div v-if="project.location == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.location }}
			    	</div>										
				</div>
			</div>
		</div>								

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Details</strong></h5>
			    	<div v-if="project.details == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.details }}
			    	</div>									
				</div>
			</div>
		</div>

	</div>

	<div class="col-md-12 margin-25-top">
		<h4>Client</h4>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Client</strong></h5>
			    	<div v-if="project.client_company_name == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.client_company_name }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Client Contact</strong></h5>
			    	<div v-if="project.client_contact_name == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.client_contact_name }}
			    	</div>										
				</div>
			</div>
		</div>								

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Contact Phone</strong></h5>
			    	<div v-if="project.client_contact_phone == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		<a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a>
			    	</div>										
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Contact Email</strong></h5>
			    	<div v-if="project.client_contact_email == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.client_contact_email }}
			    	</div>									
				</div>
			</div>
		</div>

	</div>

	<div class="col-md-12 margin-25-top">
		<h4>Land</h4>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Land Ownership</strong></h5>
			    	<div v-if="project.land_ownership == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.land_ownership }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Access Granted</strong></h5>
			    	<div v-if="project.land_access_granted == 0">No</div>
			    	<div v-if="project.land_access_granted == 1">Yes</div>
				</div>
			</div>
		</div>								

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Access Granted By</strong></h5>
			    	<div v-if="project.land_access_granted_by == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.land_access_granted_by }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Access Contact</strong></h5>
			    	<div v-if="project.land_access_contact == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ project.land_access_contact }}
			    	</div>									
				</div>
			</div>
		</div>

	</div>

	<div class="col-md-12 margin-25-top">
		<h4 class="text-success">Invoicing</h4>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Invoiced Date</strong></h5>
			    	<div v-if="project.invoiced_date == null">
			    		<span class="label label-warning">Not Invoiced</span>
			    	</div>
			    	<div v-else>
			    		{{ project.invoiced_date }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">									
				<div class="panel-body">
					<h5><strong>Date Paid</strong></h5>
			    	<div v-if="project.invoice_paid_date == null">
			    		<span class="label label-warning">Not Invoiced</span>
			    	</div>
			    	<div v-else>
			    		{{ project.invoice_paid_date }}
			    	</div>										
				</div>
			</div>
		</div>								

	</div>

	<div v-if="project.proposal" class="row margin-65-top">
		<div class="col-md-12">
			<h3>Project Proposal</h3>

			<div class="col-md-12 margin-25-top">
				<h4>Work Details</h4>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<h5><strong>Work Type</strong></h5>
					    	<div v-if="project.proposal.work_type == null">
					    		<span class="label label-warning">N/A</span>
					    	</div>
					    	<div v-else>
					    		{{ project.proposal.work_type }}
					    	</div>									
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<h5><strong>Work Overview</strong></h5>
					    	<div v-if="project.proposal.work_overview == null">
					    		<span class="label label-warning">N/A</span>
					    	</div>
					    	<div v-else>
					    		{{ project.proposal.work_overview }}
					    	</div>									
						</div>
					</div>
				</div>	
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<h5><strong>Work Plans</strong></h5>
					    	<div v-if="project.proposal.plans == null">
					    		<span class="label label-warning">N/A</span>
					    	</div>
					    	<div v-else>
					    		{{ project.proposal.plans }}
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
					    	<div v-if="project.proposal.estimate == null">
					    		<span class="label label-warning">N/A</span>
					    	</div>
					    	<div v-else>
					    		${{ project.proposal.estimate }}
					    	</div>									
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<h5><strong>Response By</strong></h5>
					    	<div v-if="project.proposal.response_by == null">
					    		<span class="label label-warning">N/A</span>
					    	</div>
					    	<div v-else>
					    		{{ project.proposal.response_by }}
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
					    	<div v-if="project.proposal.approval_date == null">
					    		<span class="label label-danger">Not yet approved</span>
					    	</div>
					    	<div v-else>
					    		{{ project.proposal.approval_date }}
					    	</div>									
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
		props: ['project']
	}
	
</script>