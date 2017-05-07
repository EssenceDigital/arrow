<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Project Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="currentTab = 'view-all'">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'create-project' }"><a v-on:click="currentTab = 'create-project'">New Project</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div class="col-md-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="info">
									<th>#</th>
									<th>Column heading</th>
									<th>Column heading</th>
									<th>Column heading</th>
								</tr>
							</thead>
						  <tbody>
							    <tr>
								    <td>1</td>
								    <td>Column content</td>
								    <td>Column content</td>
								    <td>Column content</td>
							    </tr>
							    <tr>
								    <td>2</td>
								    <td>Column content</td>
								    <td>Column content</td>
								    <td>Column content</td>
							    </tr>
						  </tbody>
						</table> 						
					</div>					
				</div>

				<div v-if="currentTab == 'create-project'" class="row margin-45-top">
					<div class="col-md-12">
						<project-form v-on:project-created="projectCreated"></project-form>
					</div>					
				</div>

				<modal></modal>

		    </div>
		</div>		
	</div>
</div>

</template>

<script>
	let project_form = require('./Project-form.vue');
	let modal = require('./../ui/Modal.vue');

	export default{
		components: {
			'project-form': project_form,
			'modal': modal
		},

		data(){
			return {
				currentTab: 'view-all',
				modalActive: false
			}
		},

		methods: {
			projectCreated(){
				
			}
		}
	}

</script>