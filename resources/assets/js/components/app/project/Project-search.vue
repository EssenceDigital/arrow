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

	<!-- Table to show projects -->				
	<table class="table table-striped table-hover margin-25-top">
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
				<a @:click="getSpecificProjectsPage(searchResults.modelsNextPageUrl)">»</a>
			</li>
		</ul>							
	</div><!-- / Pagination buttons -->

</div><!-- Containing div -->
	
</template>

<script>
	let hub_controller = require('./../_mixins/hub-controller.js');
	let dropdown = require('./../_ui/Dropdown.vue');

	export default{
		components: {
			'dropdown': dropdown
		},

		mixins: [hub_controller],		

		data(){
			return{
				urlToFetch: '/api/projects/all',
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
			this.getAndSetModels();
		}
	}
</script>

