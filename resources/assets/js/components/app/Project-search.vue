<template>

<div>
	<div v-if="searchResults.models.length > 0">
		<button v-on:click="refresh" class="btn btn-default">
			<span class="glyphicon glyphicon-refresh"></span>
			<span v-if="!fetchingModels"> Refresh list</span>
			<span v-if="fetchingModels">
				<div class="left-loader"></div>
			</span>
		</button>					
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
			    <tr v-for="project in searchResults.models" v-bind:project="project">
				    <td>{{ project.client_company_name }}</td>
				    <td>{{ project.client_contact_name }}</td>
				    <td><a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a></td>
				    <td><div v-if="project.invoiced_date == null" class="text-warning">Not Invoiced</div></td>
				    <td>
				    	<dropdown v-bind:title="'Actions'">
			    			<li><a v-on:click="editProject(project.id)">Edit</a></li>
							<li><a v-on:click="viewProject(project.id)">View full</a></li>
				    	</dropdown>
				    </td>
			    </tr>
			</tbody>
		</table>

		<div class="row text-center margin-45-top">
			<ul class="pagination">
				<li v-bind:class="{ 'disabled': searchResults.modelsCurrentPage == 1 }"><a v-on:click="getSpecificProjectsPage(searchResults.modelsPrevPageUrl)">«</a></li>
				<li v-for="(page, key) in searchResults.modelsPageLinks" v-bind:class="{ 'active': searchResults.modelsCurrentPage == key }">
					<a v-on:click="getSpecificProjectsPage(page)">{{ key }}</a>
				</li>
				<li v-bind:class="{ 'disabled': searchResults.modelsCurrentPage == searchResults.modelsPageTotal }"><a v-on:click="getSpecificProjectsPage(searchResults.modelsNextPageUrl)">»</a></li>
			</ul>							
		</div>
	</div>

	<div v-else class="col-md-8 col-centered">

		<div class="large-loader-center"></div>
							
	</div>		
</div>
	
</template>

<script>
	let hub_controller = require('./mixins/hub-controller.js');
	let dropdown = require('./../ui/Dropdown.vue');

	export default{
		components: {
			'dropdown': dropdown
		},

		mixins: [hub_controller],		

		data(){
			return{
				urlToFetch: '/app/projects/all',
				fetchingModels: false,
				searchResults: {	
					models: [],	
					modelsPageTotal: 0,
					modelsCurrentPage: 0,
					modelsPageLinks: {},
					modelsNextPageUrl: '',
					modelsPrevPageUrl: ''					
				}
			}
		},

		methods: {
			refresh(){
				this.getAndSetModels();
			},

			getSpecificProjectsPage(link){
				this.getAndSetModels(link);
			},

			editProject(id){
				this.$emit('edit', id);
			},

			viewProject(id){
				this.$emit('view', id);
			}			
		},

		mounted(){
			console.log('Search mounted');
			this.getAndSetModels();
		}
	}
</script>

