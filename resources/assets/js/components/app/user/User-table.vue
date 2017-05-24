<template>

<!-- Containing div -->
<div>
	<h3>User Details</h3>

	<!-- Tool navigation -->
	<div class="col-md-12 margin-25-top">
		<button @click="$router.push('edit')" class="btn btn-default">
			<span class="glyphicon glyphicon-cog"></span> Edit User
		</button>	
	</div>

	<!-- User table in the form of panels (first section) -->
	<div class="col-md-12 margin-25-top">
		<h4>Basics</h4>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Name</strong></h5>
			    	<div v-if="user.first == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ user.first + ' ' + user.last }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">									
				<div class="panel-body">
					<h5><strong>Email</strong></h5>
			    	<div v-if="user.email == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ user.email}}
			    	</div>										
				</div>
			</div>
		</div>								

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Permissions</strong></h5>
			    	<div v-if="user.permissions == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ user.permissions }}
			    	</div>									
				</div>
			</div>
		</div>
	</div><!-- / User table (first section) -->

	<!-- User table (second section) -->
	<div class="col-md-12 margin-25-top">
		<h4>Business</h4>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Company Name</strong></h5>
			    	<div v-if="user.company_name == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ user.company_name }}
			    	</div>									
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>GST Number</strong></h5>
			    	<div v-if="user.gst_number == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		{{ user.gst_number }}
			    	</div>										
				</div>
			</div>
		</div>								

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Hourly No. 1</strong></h5>
			    	<div v-if="user.hourly_rate_one == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		${{ user.hourly_rate_one }}
			    	</div>										
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h5><strong>Hourly No. 2</strong></h5>
			    	<div v-if="user.hourly_rate_two == null">
			    		<span class="label label-warning">N/A</span>
			    	</div>
			    	<div v-else>
			    		${{ user.hourly_rate_two }}
			    	</div>									
				</div>
			</div>
		</div>

	</div><!-- / User table (second section) -->

</div><!-- / Containing div -->

</template>

<script>
	
	export default{
		props: ['user']
	}

</script>