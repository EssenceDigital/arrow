<template>

<!-- Containing div -->	
<div>

	<!-- Loader - shows when a api call to server is pending -->
	<div v-if="fetchingModels" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<div v-if="!fetchingModels" class="row row-padded">
		<h2>Find &amp; Add Users</h2>
		<p class="margin-25-top">
			This is where you can find and sort all of the users added to the system. All individuals who will be creating timesheets must
			be added as a user.
		</p>
		<p class="margin-25-top text-info">
			<span class="glyphicon glyphicon-question-sign"></span>
			Use the view button on each user row to view and edit that user.
		</p>
		<p class="margin-25-top text-info">
			<span class="glyphicon glyphicon-question-sign"></span>
			You can add a new user using the 'Create User' link above.
		</p>								
	</div>

	<!-- Refresh models from server button -->
	<button @click="refresh" class="btn btn-default margin-35-top">
		<span class="glyphicon glyphicon-refresh"></span>
		<span v-if="!fetchingModels"> 
			Refresh list
		</span>
		<span v-if="fetchingModels">
			<div class="left-loader"></div>
		</span>
	</button>	

	<!-- Table to show users -->
	<table v-if="!fetchingModels" class="table table-striped table-hover margin-25-top">
		<thead>
			<tr class="info">
				<th>Name</th>
				<th>Email</th>
				<th>Permissions</th>
				<th>Actions</th>
			</tr>
		</thead>
	  <tbody>
		    <tr v-for="user in searchResults.models" 
		    	:user="user"
		    >
			    <td>{{ user.first + ' ' + user.last }}</td>
			    <td>{{ user.email }}</td>
			    <td>{{ user.permissions }}</td>
			    <td>
			    	<button
			    		@click="viewUser(user.id)" 
			    		class="btn btn-sm btn-success"
			    	>
			    		<span class="glyphicon glyphicon-screenshot"></span> View
			    	</button>			    
			    </td>
		    </tr>
	  </tbody>
	</table><!-- / Table to show users -->

	<!-- Pagination buttons -->	
	<div v-if="!fetchingModels" class="row text-center margin-45-top">
		<ul class="pagination">
			<li :class="{ 'disabled': searchResults.modelsCurrentPage == 1 }">
				<a @click="getSpecificProjectsPage(searchResults.modelsPrevPageUrl)">«</a>
			</li>
			<li v-for="(page, key) in searchResults.modelsPageLinks" 
				:class="{ 'active': searchResults.modelsCurrentPage == key }"
			>
				<a @click="getSpecificProjectsPage(page)">
					{{ key }}
				</a>
			</li>
			<li :class="{ 'disabled': searchResults.modelsCurrentPage == searchResults.modelsPageTotal }">
				<a @:click="getSpecificUsersPage(searchResults.modelsNextPageUrl)">»</a>
			</li>
		</ul>							
	</div><!-- / Pagination buttons -->

</div><!-- / Containing div -->	

</template>

<script>

	let api_access = require('./../_mixins/api-access.js');

	export default{

		mixins: [api_access],		

		data(){
			return{
				urlToFetch: '/api/users/all-pages',
				fetchingModels: false,
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
			// Refreshes the models cache from server
			refresh(){
				this.getAndSetModels();
			},

			// Used by the pagination buttons
			getSpecificUsersPage(link){
				this.getAndSetModels(link);
			},

			// Emits an event to parent
			viewUser(id){
				this.$router.push('/users/view/' + id + '/hub');
			}			
		},

		// Retrieves models from server
		created(){
			console.log('User search created');
			// Start loader
			this.fetchingModels = true;
			// Find projects
			this.getAndSetModels();
		}
	}
	
</script>