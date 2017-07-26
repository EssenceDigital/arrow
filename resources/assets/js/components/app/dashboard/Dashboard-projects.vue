<template>

<!-- Component container -->
<div>
	<!-- Loader - shows when a api call to server is pending -->
	<div v-if="fetchingModels" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<!-- Table wrapper - only shows after project is loaded -->
	<div v-if="!fetchingModels">
		<div class="row row-padded">
			<h2>Projects You're Part Of:</h2>
		</div>

		<!-- Tool navigation -->
		<div class="row row-padded margin-25-top">
			<!-- Refresh models from server button -->
			<button @click="refresh" class="btn btn-default">
				<span class="glyphicon glyphicon-refresh"></span>
				<span v-if="!fetchingModels"> 
					Refresh list
				</span>
				<span v-if="fetchingModels">
					<div class="left-loader"></div>
				</span>
			</button>	
		</div>		

		<!-- Client row 1 -->
		<div class="row row-padded margin-25-top">
			<!-- Field column -->
			<div v-for="project in searchResults.models" class="col-md-4">
				<div class="panel panel-white post panel-shadow">
					<!-- Show field table as default -->
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item">						
								<strong>Identifier</strong><br>
								{{ project.id }}
							</li>						
							<li class="list-group-item">						
								<strong>Province</strong><br>
								{{ project.province }}
							</li>
							<li class="list-group-item">
								<strong>Location</strong><br>
								{{ project.location }}
							</li>
							<li class="list-group-item">
								<strong>Details</strong><br>
								{{ project.details }}
							</li>
							<li class="list-group-item">
								<button v-on:click="viewTimesheets(project.id)" class="btn btn-info btn-block">
									<span class="glyphicon glyphicon-list-alt"></span>&nbsp;
									View Your Timesheets
								</button>
							</li>																					
						</ul>
														
					</div>
				</div>
			</div><!-- / Field column -->
		</div><!-- / client row 1 -->
	</div>
</div><!-- / Component container -->
	
</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		mixins: [api_access],

		data(){
			return{
				// Used by API access
				urlToFetch: '/api/dashboard/users-projects',
				// Used by API access
				fetchingModels: false,
				// Results from Laravel pagination json. Used by API access.
				searchResults: {	
					models: [],	
					modelsPageTotal: 0,
					modelsCurrentPage: 0,
					modelsPageLinks: { },
					modelsNextPageUrl: '',
					modelsPrevPageUrl: ''					
				}
			}
		},

		methods: {
			// Refreshes the models cache from server. Uses API access
			refresh(){
				this.getAndSetModels();
			},

			// Used by the pagination buttons. Uses API access
			getSpecificProjectsPage(link){
				this.getAndSetModels(link);
			},

			viewTimesheets(id){
				this.$router.push('/dashboard/projects/' + id + '/timesheets');
			}
		},

		created(){
			// Start loader
			this.fetchingModels = true;
			// Find projects
			this.getAndSetModels();	
			console.log(this.searchResults.models);		
		}	

	}

</script>