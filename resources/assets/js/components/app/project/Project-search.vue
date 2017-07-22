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

	<!-- Loader - shows when a api call to server is pending -->
	<div v-if="fetchingModels" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<!-- Table to show projects - only shows once api call has finished -->				
	<table v-if="!fetchingModels" class="table table-striped table-hover margin-25-top">
		<thead>
			<tr class="info">
				<th v-if="fullTable">Client Company</th>
				<th v-if="fullTable">Contact Name</th>
				<th v-if="fullTable">Contact Phone</th>
				<th v-if="fullTable">Invoice Paid</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		    <tr v-for="project in searchResults.models"
		    	:project="project"
		    >
			    <td v-if="fullTable">
			    	{{ project.client_company_name }}
			    </td>
			    <td v-if="fullTable">
			    	{{ project.client_contact_name }}
			    </td>
			    <td v-if="fullTable">
			    	<a :href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">
			    		{{ project.client_contact_phone }}
			    	</a>
			    </td>
			    <td v-if="fullTable">
			    	<div v-if="project.invoiced_date == null" class="text-warning">
			    		Not Invoiced
			    	</div>
			    </td>
			    <td>
			    	<button
			    		v-if="fullTable"
			    		@click="viewProject(project.id)" 
			    		class="btn btn-sm btn-success"
			    	>
			    		<span class="glyphicon glyphicon-screenshot"></span> View
			    	</button>
			    </td>
		    </tr>
		</tbody>
	</table><!-- / Table to show projects -->	
	<!-- Pagination buttons -->	
	<div v-if="!fetchingModels" class="row text-center margin-45-top">
		<ul class="pagination">
			<!-- Page back button -->
			<li :class="{ 'disabled': searchResults.modelsCurrentPage == 1 }">
				<a @click="getSpecificProjectsPage(searchResults.modelsPrevPageUrl)">«</a>
			</li>
			<!-- Page button -->
			<li v-for="(page, key) in searchResults.modelsPageLinks" 
				:class="{ 'active': searchResults.modelsCurrentPage == key }"
			>
				<a @click="getSpecificProjectsPage(page)">
					{{ key }}
				</a>
			</li>
			<!-- Page forward button -->
			<li :class="{ 'disabled': searchResults.modelsCurrentPage == searchResults.modelsPageTotal }">
				<a @click="getSpecificProjectsPage(searchResults.modelsNextPageUrl)">»</a>
			</li>
		</ul>							
	</div><!-- / Pagination buttons -->
</div><!-- Containing div -->
	
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
				fullTable: false,
				// Used by API access
				urlToFetch: '/api/projects/all',
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

			// Emits an event to parent
			viewProject(id){
				this.$router.push('/projects/view/' + id + '/hub');
			}			
		},

		// Retrieves models from server
		created(){
			console.log('Project search created');

			// Determine what route is mounting this component to determine if the full table (admin only) 
			// should be shown
			if(this.$route.path == '/projects/search'){
				this.fullTable = true;
			} else if(this.$route.path == '/dashboard/projects'){
				this.fullTable = false;
			}

			// Start loader
			this.fetchingModels = true;
			// Find projects
			this.getAndSetModels();
		}
	}
</script>

