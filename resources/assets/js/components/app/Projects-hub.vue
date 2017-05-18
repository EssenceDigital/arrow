<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Projects Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="viewAllProjectsTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'view-form' }"><a v-on:click="viewProjectFormTab">View Form</a></li>
					<li v-if="currentTab == 'view-table'" v-bind:class="{ 'active': currentTab == 'view-table' }"><a>Project as Table</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div v-if="models.length > 0" class="col-md-12">
						<button v-on:click="getAndSetProjects" class="btn btn-default">
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
							    <tr v-for="project in models" v-bind:project="project">
								    <td>{{ project.client_company_name }}</td>
								    <td>{{ project.client_contact_name }}</td>
								    <td><a v-bind:href="'tel: +1' + project.client_contact_phone.replace(/-/g, '')">{{ project.client_contact_phone }}</a></td>
								    <td><div v-if="project.invoiced_date == null" class="text-warning">Not Invoiced</div></td>
								    <td>
								    	<dropdown v-bind:title="'Actions'">
							    			<li><a v-on:click="editProject(project.id)">Edit</a></li>
											<li><a v-on:click="viewProjectTable(project.id)">View as table</a></li>
								    	</dropdown>
								    </td>
							    </tr>
							</tbody>
						</table>

						<div class="row text-center margin-45-top">
							<ul class="pagination">
								<li v-bind:class="{ 'disabled': modelsCurrentPage == 1 }"><a v-on:click="getSpecificProjectsPage(modelsPrevPageUrl)">«</a></li>
								<li v-for="(page, key) in modelsPageLinks" v-bind:class="{ 'active': modelsCurrentPage == key }">
									<a v-on:click="getSpecificProjectsPage(page)">{{ key }}</a>
								</li>
								<li v-bind:class="{ 'disabled': modelsCurrentPage == modelsPageTotal }"><a v-on:click="getSpecificProjectsPage(modelsNextPageUrl)">»</a></li>
							</ul>							
						</div>

					</div>

					<div v-if="models.length == 0" class="col-md-8 col-centered">
						<div class="alert alert-warning text-center">
							<strong>Heads up!</strong><br> No Projects are currently saved in storage.
						</div>							
					</div>	

				</div>

				<div v-if="currentTab == 'view-form'" class="row margin-45-top">
					<div class="col-md-12">
						<project-form v-bind:project="selectedModel" v-on:created="handleProjectCreation" v-on:deleted="viewAllProjectsTab">
							<div slot="nav-buttons">
								<button v-if="selectedModel" v-on:click="viewProjectTable(selectedModel.id)" class="btn btn-default">
									<span class="glyphicon glyphicon-list-alt"></span> View as Table
								</button>								
							</div>
						</project-form>
					</div>					
				</div>

				<div v-if="currentTab == 'view-table'" class="row margin-45-top">

					<div class="col-md-12">
						<button v-on:click="editProject(selectedModel.id)" class="btn btn-default">
							<span class="glyphicon glyphicon-cog"></span> Edit Project
						</button>
						<button v-if="selectedModel.proposal" v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Edit Proposal
						</button>						
						<button v-else v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Add Proposal
						</button>
					</div>

					<div v-if="projectSubTab == 'view-project'" class="col-md-12 margin-25-top">
						<project-table v-bind:project="selectedModel">
							
						</project-table>
					</div><!-- / view-project sub tab -->	

					<div v-if="projectSubTab == 'proposal-form'" class="col-md-12 margin-25-top">
						<proposal-form v-bind:proposal="selectedModel.proposal" v-bind:project_id="selectedModel.id" v-on:created="handleProposalCreation">
							<button slot="close" v-on:click="projectSubTab = 'view-project'" class="pull-right btn btn-danger">
								&times;
							</button>
						</proposal-form>
					</div><!-- / add-proposal sub tab -->	

				</div><!-- / view-table tab -->

		    </div>
		</div>		
	</div>
</div>

</template>

<script>
	let project_form = require('./Project-form.vue');
	let project_table = require('./Project-table.vue');
	let proposal_form = require('./Proposal-form.vue');
	let dropdown = require('./../ui/Dropdown.vue');
	let hub_controller = require('./mixins/hub-controller.js');

	export default{
		components: {
			'project-form': project_form,
			'project-table': project_table,
			'proposal-form': proposal_form,
			'dropdown': dropdown
		},

		mixins: [hub_controller],

		data(){
			return {
				currentTab: 'view-all',
				projectSubTab: 'view-project',
				urlToFetch: '/app/projects/all',				
				fetchingModels: false,	
				models: [],	
				modelsPageTotal: 0,
				modelsCurrentPage: 0,
				modelsPageLinks: {},
				modelsNextPageUrl: '',
				modelsPrevPageUrl: '',
				selectedModel: false			
			}
		},

		methods: {

			viewAllProjectsTab(){
				this.viewAllModelsTab();
			},

			viewProjectFormTab(){
				// Reset selected model
				this.selectedModel = false;
				this.viewFormTab();
			},

			handleProjectCreation(model){
				// Set the active model to the one just created
				this.selectedModel = model;
				this.viewModelAsTable();
			},

			getAndSetProjects(){
				this.getAndSetModels();
			},

			getSpecificProjectsPage(link){
				this.getAndSetModels(link);
			},

			viewProjectTable(id){
				// Get a fresh version of the requested model
				this.grabModelFromServer('/app/projects/' + id, function(){
					// Show table style view
					this.viewModelAsTable();
				});				
			},

			editProject(id){
				// Get a fresh version of the requested model
				this.grabModelFromServer('/app/projects/' + id, function(){
					// Show form
					this.viewFormTab();
				});				
			},

			handleProposalCreation(proposal){
				// Add proposal to project
				this.selectedModel.proposal = proposal;
				this.projectSubTab = 'view-project';
			},

			editProposal(id){
				
			},

		},

		// Retrieves all projects from storage upon compenent mounting
		mounted(){
			this.getAndSetModels();
		}

	}

</script>