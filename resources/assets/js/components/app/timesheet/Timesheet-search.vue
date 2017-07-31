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
		<h2>Find &amp; Search Timesheets</h2>
		<p class="margin-25-top">
			This is where you can find and sort all timesheets within the system. Use the filter form below to narrow down your search.
		</p>
		<p class="margin-25-top text-info">
			<span class="glyphicon glyphicon-question-sign"></span>
			You can also view timesheets for a specific user in their user profile page.
		</p>								
	</div>

		<div class="row row-padded  margin-35-top">

			<div class="col-md-2">
				<div class="form-group">
                	<label class="control-label">From</label>
                	<input v-model="fromDateFilter" type="date" class="form-control margin-10-top">
              	</div>				
			</div>

			<div class="col-md-2">
				<div class="form-group">
                	<label class="control-label">To</label>
                	<input v-model="toDateFilter" type="date" class="form-control margin-10-top">
              	</div>				
			</div>

			<div class="col-md-2">
				<div class="form-group">
                	<label class="control-label">Project Identifier</label>
                	<input v-model="projectIdFilter" type="number" min="1" class="form-control margin-10-top">
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
						Filter Projects
					</span>
					<span v-if="fetchingModels">
						<div class="left-loader"></div>
					</span>
				</button>				
			</div>					
			
		</div>

	<!-- Table to show users -->
	<table v-if="!fetchingModels" class="table table-striped table-hover margin-25-top">
		<thead>
			<tr class="info">
				<th>Date</th>
				<th>Project</th>
				<th>User</th>
				<th>Invoice Total</th>
				<th>Work Hours</th>
				<th>Actions</th>
			</tr>
		</thead>
	  <tbody>
		    <tr v-for="timesheet in searchResults.models" 
		    >
			    <td>{{ new Date(Date.parse(timesheet.date + 'T00:00:00')).toDateString() }}</td>
			    <td>{{ timesheet.project_id }}</td>
			    <td>{{ timesheet.user.first + ' ' + timesheet.user.last }}</td>
			    <td>${{ tallyATimesheetsTotal(timesheet) }}</td>
			    <td>{{ countATimesheetsHours(timesheet) }}</td>
			    <td>
			    	<button
			    		@click="" 
			    		class="btn btn-sm btn-success"
			    	>
			    		<span class="glyphicon glyphicon-screenshot"></span> More
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
				urlToFetch: '/api/timesheets/all',
				fetchingModels: false,
				searchResults: {	
					models: [],	
					modelsPageTotal: 0,
					modelsCurrentPage: 0,
					modelsPageLinks: { },
					modelsNextPageUrl: '',
					modelsPrevPageUrl: ''					
				},
				fromDateFilter: '',
				toDateFilter: '',
				projectIdFilter: '',
				perPageFilter: 15
			}
		},

		methods: {
			// Refreshes the models cache from server
			filter(){
				this.filterAndSetModels('/api/timesheets/filter', {
					to_date: this.toDateFilter,
					from_date: this.fromDateFilter,
					project_id: this.projectIdFilter,
					per_page: this.perPageFilter
				});				
			},

			// Used by the pagination buttons
			getSpecificUsersPage(link){
				this.getAndSetModels(link);
			},

			tallyATimesheetsTotal(timesheet){
				var hours = this.countATimesheetsHours(timesheet),
					equipmentCost = this.countATimesheetsEquipment(timesheet),
					otherCosts = this.countATimesheetsOtherCosts(timesheet),
					hourPay = parseFloat(hours) * parseFloat(DASHBOARD_USER_HOURLY),
					// Total
					timesheetTotal = equipmentCost + otherCosts + hourPay;

				return parseFloat(timesheetTotal);
			},

			countATimesheetsHours(timesheet){
				var hours = 0;
				timesheet.work_jobs.forEach(function(workJob){
					hours += parseFloat(workJob.hours_worked);
				});
				return hours;
			},

			countATimesheetsEquipment(timesheet){
				var total = 0;
				timesheet.equipment_rentals.forEach(function(rental){
					total += parseFloat(rental.rental_fee);
				});
				return total;
			},

			countATimesheetsOtherCosts(timesheet){
				var total = 0;
				timesheet.other_costs.forEach(function(cost){
					total += parseFloat(cost.cost);
				});
				return total;
			},
		
		},

		// Retrieves models from server
		created(){
			console.log('Timesheet search created');
			// Start loader
			this.fetchingModels = true;
			// Find projects
			this.getAndSetModels();
		}
	}
	
</script>