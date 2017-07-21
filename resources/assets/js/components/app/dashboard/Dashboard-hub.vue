<template>

<!-- Component container -->
<div>
	<!-- Containing row -->
	<div class="row margin-75-top">
		<div class="col-md-12">
		
			<!-- Panel -->	
			<div class="panel panel-primary">
				<!-- Panel heading -->
			    <div class="panel-heading">
			    	<h3 class="panel-title">User Dasboard</h3>
			    </div>
			    <!-- Panel body -->
			    <div class="panel-body">

			    	<!-- Hub navigation (changes between tabs / router views) -->
					<ul class="nav nav-pills">
						<li :class="{ 'active': $route.path == '/dashboard/projects' }">
							<router-link to="/dashboard/projects">
								Assigned Projects
							</router-link>
						</li>	
						<li  v-if="$route.path == ('/dashboard/timesheets/'+$route.params.project_id)"
							:class="{ 'active': $route.path == '/dashboard/timesheets/'+$route.params.project_id }">
							<router-link to="'/dashboard/timesheets/'+$route.params.project_id">
								Project Timesheets
							</router-link>
						</li>																
					</ul>	

					<!-- Tabs are here -->
					<div class="row margin-45-top">

						<div class="col-md-12">
							<!-- Show tab component -->
							<router-view></router-view>
						</div>

					</div><!-- / mounting tab -->

			    </div><!-- / panel body -->	
			</div><!-- / panel -->

		</div><!-- / col -->
	</div><!-- / / row -->
</div><!-- / Component container -->

</template>

<script>
	
</script>