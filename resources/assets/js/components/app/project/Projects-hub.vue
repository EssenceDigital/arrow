<template>

<!-- Containing row -->
<div class="row margin-75-top">
	<div class="col-md-12">
	
		<!-- Panel -->	
		<div class="panel panel-primary">
			<!-- Panel heading -->
		    <div class="panel-heading">
		    	<h3 class="panel-title">Projects Hub</h3>
		    </div>
		    <!-- Panel body -->
		    <div class="panel-body">

		    	<!-- Hub navigation (changes between tabs / router views) -->
				<ul class="nav nav-pills">
					<li :class="{ 'active': $route.path == '/projects/search' }">
						<router-link to="/projects/search">
							View all
						</router-link>
					</li>
					<li :class="{ 'active': $route.path == '/projects/create' }">
						<router-link to="/projects/create">
							Create Project
						</router-link>
					</li>
					<li v-if="$route.path == ('/projects/view/'+$route.params.id+'/hub')" 
						:class="{ 'active': $route.path == ('/projects/view/'+$route.params.id+'/hub') }"
					>
						<a>Viewing Project</a>
					</li>
					<li v-if="$route.path == ('/projects/view/'+$route.params.id+'/edit')" 
						:class="{ 'active': $route.path == ('/projects/view/'+$route.params.id+'/edit') }"
					>
						<a>Editing Project</a>
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

</template>

<script>

	export default{

		// Mostly coordinates events from children components
		created(){
			console.log("Projects hub created");

			// When the form component alerts this parent of a successful creation
			this.$router.app.$on('model-created', model => {
				// Redirect
				this.$router.push('/projects/view/'+model.id+'/hub');				
			});

			// When the form component alerts this parent of a successful creation
			this.$router.app.$on('model-deleted', function() {
				// Redirect
				this.$router.push('/projects/search');				
			});			

		}

	}

</script>