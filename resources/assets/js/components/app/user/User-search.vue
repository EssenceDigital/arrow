<template>

<!-- Containing div -->	
<div>
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

	<!-- Table to show users -->
	<table class="table table-striped table-hover margin-25-top">
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
			    	<dropdown v-bind:title="'Actions'">
						<li>
							<a @click="viewUser(user.id)">View full</a>
						</li>
			    	</dropdown>
			    </td>
		    </tr>
	  </tbody>
	</table><!-- / Table to show users -->

	<!-- Pagination buttons -->	
	<div class="row text-center margin-45-top">
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
	let dropdown = require('./../_ui/Dropdown.vue');

	export default{
		components: {
			'dropdown': dropdown
		},

		mixins: [api_access],		

		data(){
			return{
				urlToFetch: '/api/users/all',
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
			this.getAndSetModels();
		}
	}
	
</script>