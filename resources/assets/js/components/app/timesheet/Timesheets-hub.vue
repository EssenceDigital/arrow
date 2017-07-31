<template>
	
<!-- Containing row -->
<div class="row margin-95-top">
	<div class="col-md-12">

		<!-- Panel -->
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Timesheets Hub</h3>
		    </div>
		    <!-- Panel body -->
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li :class="{ 'active': $route.path == '/timesheets/search' }">
						<router-link to="/timesheets/search">
							View all
						</router-link>
					</li>
				</ul>		    	

				<!-- Tabs are here -->
				<div class="row margin-25-top">

					<div class="col-md-12">
						<!-- Show tab component -->
						<router-view></router-view>
					</div>

				</div><!-- / mounting tab -->

		    </div><!-- / Panel body -->
		</div><!-- / Panel -->

	</div>
</div><!-- / Containing row -->

</template>

<script>
	
</script>