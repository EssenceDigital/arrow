<template>

<div class="row margin-75-top">
	<div class="col-md-12">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Users Hub</h3>
		    </div>
		    <div class="panel-body">
				<ul class="nav nav-pills">
					<li v-bind:class="{ 'active': currentTab == 'view-all' }"><a v-on:click="showAllUsersTab">View All</a></li>
					<li v-bind:class="{ 'active': currentTab == 'create-user' }"><a v-on:click="currentTab = 'create-user'">New User</a></li>
				</ul>		    	

				<div v-if="currentTab == 'view-all'" class="row margin-45-top">
					<div class="col-md-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="info">
									<th>Name</th>
									<th>Email</th>
									<th>Permissions</th>
									<th>Actions</th>
								</tr>
							</thead>
						  <tbody>
							    <tr v-for="user in users" v-bind:user="user">
								    <td>{{ user.first + ' ' + user.last }}</td>
								    <td>{{ user.email }}</td>
								    <td>{{ user.permissions }}</td>
								    <td>
								    	<dropdown></dropdown>
								    </td>
							    </tr>
						  </tbody>
						</table> 						
					</div>					
				</div>

				<div v-if="currentTab == 'create-user'" class="row margin-45-top">
					<div class="col-md-12">
						<user-form></user-form>
					</div>					
				</div>

				<modal></modal>

		    </div>
		</div>		
	</div>
</div>
	
</template>

<script>
	let user_form = require('./User-form.vue');
	let modal = require('./Modal.vue');
	let dropdown = require('./../ui/Dropdown.vue');

	export default{
		components: {
			'user-form': user_form,
			'modal': modal,
			'dropdown': dropdown
		},

		data(){
			return {
				currentTab: 'view-all',
				modalActive: false,
				users: []
			}
		},

		methods: {
			userCreated(){
				
			},

			showAllUsersTab(){
				this.currentTab = 'view-all';
				this.getAndSetUsers();
			},

			// Sends a GET request to retrieve all users from the server then sets the users data prop
			getAndSetUsers(){
				var context = this;
				// Send request
				axios.get('/app/users/all')
					.then(function(response){
						// Set data prop
						context.users = response.data.users;
					})
					.catch(function(response){
						console.log(response);
					});					
			}
		},

		mounted(){
			this.getAndSetUsers();
		}

	}
	
</script>