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
			<h3>Project Details</h3>
		</div>
		<!-- Tool navigation -->
		<div class="row row-padded margin-25-top">
			<button @click="$router.push('edit')" class="btn btn-default">
				<span class="glyphicon glyphicon-cog"></span> Edit Project
			</button>		
		</div>
		<!-- Project table in the form of panels -->
		<div class="row row-padded margin-25-top">
			<h4>Location</h4>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Province</strong></h5>
				    	<div v-if="project.province == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.province }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-white post panel-shadow">									
					<div class="panel-body">
						<h5><strong>Location</strong></h5>
				    	<div v-if="project.location == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.location }}
				    	</div>										
					</div>
				</div>
			</div>								
			<div class="col-md-12">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Details</strong></h5>
				    	<div v-if="project.details == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.details }}
				    	</div>									
					</div>
				</div>
			</div>
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h4>Client</h4>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Client</strong></h5>
				    	<div v-if="project.client_company_name == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.client_company_name }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Client Contact</strong></h5>
				    	<div v-if="project.client_contact_name == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.client_contact_name }}
				    	</div>										
					</div>
				</div>
			</div>								
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Contact Phone</strong></h5>
				    	<div v-if="project.client_contact_phone == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		<a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a>
				    	</div>										
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Contact Email</strong></h5>
				    	<div v-if="project.client_contact_email == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.client_contact_email }}
				    	</div>									
					</div>
				</div>
			</div>
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h4>Land</h4>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Land Ownership</strong></h5>
				    	<div v-if="project.land_ownership == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.land_ownership }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Access Granted</strong></h5>
				    	<div v-if="project.land_access_granted == 0">No</div>
				    	<div v-if="project.land_access_granted == 1">Yes</div>
					</div>
				</div>
			</div>								
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Access Granted By</strong></h5>
				    	<div v-if="project.land_access_granted_by == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.land_access_granted_by }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Access Contact</strong></h5>
				    	<div v-if="project.land_access_contact == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.land_access_contact }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Access Contact Phone</strong></h5>
				    	<div v-if="project.land_access_phone == null">
				    		<span class="label label-danger">N/A</span>
				    	</div>
				    	<div v-else>
				    		{{ project.land_access_phone }}
				    	</div>									
					</div>
				</div>
			</div>			
		</div><!-- / row padded-->

		<hr class="dotted"><!-- Divider -->

		<div class="row row-padded margin-25-top">
			<h4>Invoicing</h4>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<div class="panel-body">
						<h5><strong>Invoiced Date</strong></h5>
				    	<div v-if="project.invoiced_date == null">
				    		<span class="label label-danger">Not Invoiced</span>
				    	</div>
				    	<div v-else>
				    		{{ project.invoiced_date }}
				    	</div>									
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white post panel-shadow">									
					<div class="panel-body">
						<h5><strong>Date Paid</strong></h5>
				    	<div v-if="project.invoice_paid_date == null">
				    		<span class="label label-danger">Not Invoiced</span>
				    	</div>
				    	<div v-else>
				    		{{ project.invoice_paid_date }}
				    	</div>										
					</div>
				</div>
			</div>								
		</div><!-- / row padded-->

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
			}
		},

		watch:{
			// Wait for the project prop to be populated and then turn off loading
			project(){
				this.isLoading = false;
			}
		},

		methods:{
			removeNote(){

			}
		},

		created(){
			console.log('Project table created');
			// Show loader if no project cached
			if(this.project.id == null){
				this.isLoading = true;
			}
		}
	}

</script>