<template>

<!-- Containing row -->
<div class="row margin-95-top">
	<div class="col-md-12">

		<!-- Panel -->
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Users Hub</h3>
		    </div>
		    <!-- Panel body -->
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li :class="{ 'active': $route.path == '/users/search' }">
						<router-link to="/users/search">
							View all
						</router-link>
					</li>
					<li :class="{ 'active': $route.path == '/users/create' }">
						<router-link to="/users/create">
							Create User
						</router-link>
					</li>
					<li v-if="$route.path == ('/users/view/'+$route.params.id+'/hub')" 
						:class="{ 'active': $route.path == ('/users/view/'+$route.params.id+'/hub') }"
					>
						<a>Viewing User</a>
					</li>
					<li v-if="$route.path == ('/users/view/'+$route.params.id+'/edit')" 
						:class="{ 'active': $route.path == ('/users/view/'+$route.params.id+'/edit') }"
					>
						<a>Editing User</a>
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

	export default{

		// Mostly coordinates events from children components
		created(){
			console.log("Users hub created");

			// When the form component alerts this parent of a successful creation
			this.$router.app.$on('user-created', model => {
				// Redirect
				this.$router.push('/users/view/'+model.id+'/hub');				
			});

			// When the form component alerts this parent of a successful creation
			this.$router.app.$on('user-deleted', function() {
				// Redirect
				this.$router.push('/users/search');				
			});			

		}

	}
	
</script>