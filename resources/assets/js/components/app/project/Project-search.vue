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
				<th>Client Company</th>
				<th>Contact Name</th>
				<th>Contact Phone</th>
				<th>Invoice Paid</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		    <tr v-for="project in searchResults.models"
		    	:project="project"
		    >
			    <td>
			    	{{ project.client_company_name }}
			    </td>
			    <td>
			    	{{ project.client_contact_name }}
			    </td>
			    <td>
			    	<a :href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">
			    		{{ project.client_contact_phone }}
			    	</a>
			    </td>
			    <td>
			    	<div v-if="project.invoiced_date == null" class="text-warning">
			    		Not Invoiced
			    	</div>
			    </td>
			    <td>
			    	<dropdown v-bind:title="'Actions'">
						<li>
							<a @click="viewProject(project.id)">View full</a>
						</li>
			    	</dropdown>
			    </td>
		    </tr>
		</tbody>
	</table><!-- / Table to show projects -->	
	<!-- Pagination buttons -->	
	<div class="row text-center margin-45-top">
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
				urlToFetch: '/api/projects/all',
				fetchingModels: false,
				// Results from Laravel pagination json
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
			// Start loader
			this.fetchingModels = true;
			// Find projects
			this.getAndSetModels();
		}
	}
</script>

