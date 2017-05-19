<template>

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

		    	<!-- Hub navigation (changes between tabs) -->
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="viewAllProjectsTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'view-form' }"><a v-on:click="viewProjectFormTab">View Form</a></li>
					<li v-if="currentTab == 'view-table'" v-bind:class="{ 'active': currentTab == 'view-table' }"><a>Project as Table</a></li>
				</ul>	

				<!-- Search tab -->
				<div v-if="currentTab == 'view-all'" class="row margin-45-top">

					<div class="col-md-12">
						<!-- Search componenet -->
						<project-search v-on:edit="editProject" v-on:view="viewProjectTable"></project-search>
					</div>

				</div><!-- / Search tab -->

				<!-- Form tab -->
				<div v-if="currentTab == 'view-form'" class="row margin-45-top">

					<div class="col-md-12">
						<!-- Form componenet -->
						<project-form v-bind:project="selectedModel" v-on:created="handleProjectCreation" v-on:deleted="viewAllProjectsTab">
							<!-- Button slot -->
							<div slot="nav-buttons">
								<button v-if="selectedModel" v-on:click="viewProjectTable(selectedModel.id)" class="btn btn-default">
									<span class="glyphicon glyphicon-list-alt"></span> View as Table
								</button>								
							</div>
						</project-form>
					</div>

				</div><!-- / Form tab -->

				<!-- View table tab -->
				<div v-if="currentTab == 'view-table'" class="row margin-45-top">

					<!-- Tool navigation -->
					<div class="col-md-12">
						<button v-on:click="editProject(selectedModel.id)" class="btn btn-default">
							<span class="glyphicon glyphicon-cog"></span> Edit Project
						</button>
						<!-- If show add or edit proposal -->
						<button v-if="selectedModel.proposal" v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Edit Proposal
						</button>						
						<button v-else v-on:click="projectSubTab = 'proposal-form'" class="btn btn-default margin-10-left">
							<span class="glyphicon glyphicon-briefcase"></span> Add Proposal
						</button>
					</div>

					<!-- View project sub-tab -->
					<div v-if="projectSubTab == 'view-project'" class="col-md-12 margin-25-top">
						<!-- Table component -->
						<project-table v-bind:project="selectedModel"></project-table>
					</div><!-- / view-project sub tab -->	

					<!-- Proposal form sub-tab -->
					<div v-if="projectSubTab == 'proposal-form'" class="col-md-12 margin-25-top">
						<!-- Proposal form component -->
						<proposal-form v-bind:proposal="selectedModel.proposal" v-bind:project_id="selectedModel.id" v-on:created="handleProposalCreation">\
							<!-- Close slot to change sub-tab back -->
							<button slot="close" v-on:click="projectSubTab = 'view-project'" class="pull-right btn btn-danger">
								&times;
							</button>
						</proposal-form>
					</div><!-- / add-proposal sub tab -->	

				</div><!-- / view-table tab -->

		    </div><!-- / panel body -->	
		</div><!-- / panel -->	
	</div><!-- / col -->
</div><!-- / / row -->

</template>

<script>
	let project_search = require('./Project-search.vue');
	let project_form = require('./Project-form.vue');
	let project_table = require('./Project-table.vue');
	let proposal_form = require('./Proposal-form.vue');
	let dropdown = require('./../ui/Dropdown.vue');
	let hub_controller = require('./mixins/hub-controller.js');

	export default{
		components: {
			'project-search': project_search,
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
				// Current selected project (can be false or a project model [json])
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

			// When a project-form alerts this parent to a creation
			handleProjectCreation(model){
				// Set the active model to the one just created
				this.selectedModel = model;
				this.viewModelAsTable();
			},

			// Gets an updated model and shows the full table view
			viewProjectTable(id){
				// Get a fresh version of the requested model
				this.grabModelFromServer('/app/projects/' + id, function(){
					// Show table style view
					this.viewModelAsTable();
				});				
			},

			// Gets an updated model and shows the form for editing
			editProject(id){
				// Get a fresh version of the requested model
				this.grabModelFromServer('/app/projects/' + id, function(){
					// Show form
					this.viewFormTab();
				});				
			},

			// When a proposal-form alerts this parent to a creation
			handleProposalCreation(proposal){
				// Add proposal to project
				this.selectedModel.proposal = proposal;
				this.projectSubTab = 'view-project';
			},

			editProposal(id){
				
			},

		},

		mounted(){
			console.log("Hub mounted");
			//this.getAndSetModels();
		}

	}

</script>