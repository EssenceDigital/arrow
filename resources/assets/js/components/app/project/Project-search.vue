<template>

<!-- Containing div -->
<div>

	<!-- Loader - shows when a api call to server is pending -->
	<div v-if="fetchingModels" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>	

	<div v-if="!fetchingModels">
		<!-- Show the user only intro -->
		<div v-if="tableState == 'user'">
			<div class="row row-padded">
				<h2>Your Projects</h2>
				<p class="margin-25-top">
					This is where you'll find all of the projects that you're a part of.
				</p>
				<p class="margin-25-top text-info">
					<span class="glyphicon glyphicon-question-sign"></span>
					Use the view button on each project row to view your timesheets for that project or add new ones.
				</p>
				<p class="margin-25-top">
					<h4>
						<strong>Number of Projects:</strong> <span class="label label-success">{{ searchResults.models.length}}</span>
					</h4>
				</p>				
			</div>			
		</div>

		<!-- Show the admin only intro -->
		<div v-if="tableState == 'admin'">
			<div class="row row-padded">
				<h2>Find &amp; Add Projects</h2>
				<p class="margin-25-top">
					This is where you can find and sort all of the projects added to the system.
				</p>
				<p class="margin-25-top text-info">
					<span class="glyphicon glyphicon-question-sign"></span>
					You can add a new project using the 'Create Project' link above.
				</p>				
				<p class="margin-25-top text-info">
					<span class="glyphicon glyphicon-question-sign"></span>
					Use the view button on each project row to view and edit that project.
				</p>
				<p class="margin-25-top text-info">
					<span class="glyphicon glyphicon-question-sign"></span>
					You can filter the projects using the form below. You can leave fields blank.
				</p>								
			</div>			
		</div>	


		<div v-if="tableState == 'adminUser'" class="row row-padded margin-25-top">
			<h2>Projects {{ user.first }}'s Involved In</h2>
			<p class="margin-25-top">
				This is where you can keep track of {{ user.first }}'s timesheets.
			<p class="margin-25-top text-info">
				<span class="glyphicon glyphicon-question-sign"></span>
				Use the view button on each project row to view {{ user.first }}'s timesheets for that project.
			</p>
		</div>

		<div v-if="tableState == 'admin'" class="row row-padded  margin-35-top">

			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Filter by Company</label>
					<select v-model="clientCompanyFilter" class="form-control margin-10-top">
						<option value="" selected>Select company...</option>
						<option v-for="client in clients" 
							:value="client"
						>
							{{ client }}
						</option>
                    </select>
				</div>				
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Filter by Province</label>
					<select v-model="projectProvinceFilter" class="form-control margin-10-top">
						<option value="" selected>Select province...</option>
                    	<option value="Alberta">Alberta</option>
                        <option value="British Columbia">British Columbia</option>
                        <option value="Saskatchewan">Saskatchewan</option>
                    </select>
				</div>				
			</div>	

			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Filter Invoice Status</label>
					<select v-model="invoiceStatusFilter" class="form-control margin-10-top">
						<option value="" selected>Select status...</option>
                        <option value="0">Not Paid</option>
                        <option value="1">Paid</option>
                    </select>
				</div>				
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label class="control-label">Per Page</label>
					<select v-model="perPageFilter" class="form-control margin-10-top">
						<option value="15" selected>15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="10000">*All</option>
                    </select>
				</div>				
			</div>
			<div class="col-md-2">
				<!-- Refresh models from server button -->
				<button @click="filter" class="btn btn-default btn-block margin-35-top">
					<span class="glyphicon glyphicon-search"></span>
					<span v-if="!fetchingModels"> 
						Filter
					</span>
					<span v-if="fetchingModels">
						<div class="left-loader"></div>
					</span>
				</button>				
			</div>					
			
		</div>

	</div>



	<!-- Table to show projects - only shows once api call has finished 
	**** The table fields change depending on whether it's being viewed from and admin
	**** or user perspective
	-->				
	<table v-if="!fetchingModels" class="table table-striped table-hover margin-25-top">
		<!-- Table header -->
		<thead>
			<tr class="info">
				<!-- Universal headers -->
				<th>
					Identifier
				</th>

				<!-- Admin viewing only headers -->
				<th v-if="tableState == 'admin'">
					Client Company
				</th>
				<th v-if="tableState == 'admin'">
					Province
				</th>
				<th v-if="tableState == 'admin'">
					Location
				</th>				
				<th v-if="tableState == 'admin'">
					Invoice Status
				</th><!-- / Admin viewing only headers -->

				<!-- User viewing only headers -->				
				<th v-if="tableState=='user' || tableState =='adminUser'">
					Province
				</th>
				<th v-if="tableState=='user' || tableState =='adminUser'">
					Location
				</th>
				<th v-if="tableState=='user' || tableState =='adminUser'">
					Timesheets
				</th>

				<!-- Actions header shows at all times -->
				<th>
					Actions
				</th>
			</tr>
		</thead><!-- / Table header -->
		<!-- Table body -->
		<tbody>
		    <tr v-for="project in searchResults.models"
		    	:project="project"
		    >
		    	<!-- Universal fields -->
			    <td>
			    	{{ project.id }}
			    </td>

		    	<!-- Admin viewing only fields -->
			    <td v-if="tableState == 'admin'">
			    	{{ project.client_company_name }}
			    </td>
			    <td v-if="tableState == 'admin'">
			    	{{ project.province }}
			    </td>
			    <td v-if="tableState == 'admin'">
			    	{{ project.location }}
			    </td>
			    <td v-if="tableState == 'admin'">
			    	<div v-if="project.invoice_paid_date == null">
			    		<span v-if="project.invoiced_date == null" class="label label-warning">Not Invoiced</span>
			    		<span v-else class="label label-danger">Not Paid (invoiced)</span>
			    	</div>
			    	<div v-else>
			    		<span class="label label-success">Paid</span>
			    	</div>
			    </td><!-- / Admin viewing only fields -->

			    <!-- User viewing only fields -->			    
			    <td v-if="tableState=='user' || tableState =='adminUser'">
			    	{{ project.province }}
			    </td>
			    <td v-if="tableState=='user' || tableState =='adminUser'">
			    	{{ project.location }}
			    </td>
			    <td v-if="tableState=='user' || tableState =='adminUser'">
			    	{{ project.timesheets.length }}
			    </td>

			    <!-- Action field -->
			    <td>
			    	<!-- Admin viewing only button -->
			    	<button
			    		v-if="tableState == 'admin'"
			    		@click="viewProject(project.id)" 
			    		class="btn btn-sm btn-success"
			    	>
			    		<span class="glyphicon glyphicon-screenshot"></span> View
			    	</button>

			    	<!-- User viewing only button -->
			    	<button
			    		v-if="tableState=='user' || tableState =='adminUser'"
			    		@click="viewTimesheets(project.id, project.timesheets.length)" 
			    		class="btn btn-sm btn-success"
			    	>
			    		<span class="glyphicon glyphicon-screenshot"></span> View
			    	</button>			    	
			    </td>
		    </tr>
		</tbody><!-- / Table body -->
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

		/* @param - user - Component can be mounted from the /users/view/{id}/hub route and it needs the user
		*/
		props: ['user'],

		mixins: [api_access],		

		data(){
			return{
				// The table can have three different states that alter the way it displays
				tableState: '',
				// Used by API access. Set in the created method
				urlToFetch: '',
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
				},
				// Unique project clients
				clients: [],
				clientCompanyFilter: '',
				projectProvinceFilter: '',
				invoiceStatusFilter: '',
				perPageFilter: 15
			}
		},

		methods: {
			// Refreshes the models cache from server. Uses API access
			refresh(){
				this.getAndSetModels();
			},

			filter(){
				this.filterAndSetModels('/api/projects/filter', {
					client_company_name: this.clientCompanyFilter,
					province: this.projectProvinceFilter,
					invoice_paid_date: this.invoiceStatusFilter,
					per_page: this.perPageFilter
				});
			},

			// Used by the pagination buttons. Uses API access
			getSpecificProjectsPage(link){
				this.getAndSetModels(link);
			},

			/* Routes to the full view of the project
			 * Can only be called from the admin only button
			*/ 
			viewProject(id){
				this.$router.push('/projects/view/' + id + '/hub');
			},

			/* Routes to the users dashboard view showing their timesheets for the selected project
			 * Can only be called from the admin only button
			*/ 
			viewTimesheets(id, timesheets){
				if(this.tableState == 'user'){
					this.$router.push('/dashboard/projects/' + id + '/timesheets');
				} else if(this.tableState == 'adminUser'){
					// If there is timesheets then proceed
					if(timesheets > 0){
						if(this.user){
							this.$router.push('/users/view/' + this.user.id + '/projects/' + id + '/timesheets');
						}
					} else {
						// If no timesheets then don't bother proceeding
		                 noty({
		                     text: '<h4>No timesheets on this project</h4>',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 1200,
		                     closeWith: ['click', 'hover'],
		                     type: 'warning'
		                });								
					}
				}			
			},

			// Retrieve all the unique clients from api
			getAndSetUniqueClients(){
				var context = this;
				// Send request to retrieve unique clients
				axios.get('/api/projects/unique-clients')
					.then(function(response){
						// Set the clients prop
						context.clients = response.data.clients;
					})
					.catch(function(error){
						console.log(error);
					});
			}						
		},

		// Retrieves models from server
		created(){
			console.log('Project search created');

			// Determine what route is mounting this component to determine if the full table (admin only) 
			// should be shown
			if(this.$route.path == '/projects/search'){
				// Verify the current user is an admin for extra security
				if(DASHBOARD_USER_PERMISSIONS == 'admin'){
					this.tableState ='admin';
					this.urlToFetch = '/api/projects/all';
					// Start loader
					this.fetchingModels = true;
					// Find projects
					this.getAndSetModels();	
					// Get unique clients
					this.getAndSetUniqueClients();				
				}
			} else if(this.$route.path == '/dashboard/projects'){
				this.tableState = 'user';
				this.urlToFetch = '/api/dashboard/users-projects';
				// Start loader
				this.fetchingModels = true;
				// Find projects
				this.getAndSetModels();				
			} 

			// If a param called id in the route then the component is likely mounted from the users/view/{id}/hub route
			// so check for that
			if(this.user){
				console.log(this.user)
				if(this.$route.path == '/users/view/'+this.user.id+'/hub'){
					console.log('route');
					// Verify the current user is an admin for extra security
					if(DASHBOARD_USER_PERMISSIONS == 'admin'){
						this.tableState = 'adminUser';
						this.urlToFetch = '/api/users/'+this.user.id+'/projects';
						// Start loader
						this.fetchingModels = true;
						// Find projects
						this.getAndSetModels();

					}
				}
			}

		}
	}
</script>

