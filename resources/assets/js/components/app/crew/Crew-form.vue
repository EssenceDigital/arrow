<template>

<!-- Component container -->
<div>
	<!-- Loader - shows if data is fetching -->
	<div v-if="formIsLoading" class="row margin-85-top margin-85-bottom">
		<div class="col-md-12">
			<div class="large-center-loader"></div>
		</div>
	</div>

	<!-- Form wrapper 'well' -->
	<div v-if="!formIsLoading" class="col-md-12 well bs-component margin-25-top">
		<!-- crew form -->
		<form @submit.prevent class="form-horizontal">
			<fieldset>
				<legend>
					{{ form.title }}
					<!-- Close slot to change sub-tab back -->
					<button slot="close" @click="$router.go(-1)" class="pull-right btn btn-danger">&times;</button>
				</legend>

				<div class="row">
					<div class="col-md-4 col-centered">
						<div class="form-group" :class="{'has-error': form.fields.user_id.err}">
							<div class="col-md-12">
								<label class="control-label">Choose a user for the crew</label>
								<select v-model="form.fields.user_id.val" class="form-control margin-10-top">
									<option value="" selected disabled="">Select...</option>
									<option v-for="user in users"
										:value="user.id"
									>
										{{ user.first + ' ' + user.last }}
									</option>
			                    </select>
			                    <span class="text-danger" v-if="form.fields.user_id.err">{{ form.fields.user_id.err }}</span>
							</div>
						</div>					
					</div>
				</div>
			</fieldset>
			<!-- Button -->
			<fieldset>
				<div class="row">
					<div class="col-md-3 col-centered">
						<div class="form-group">
							<button @click="sendForm" class="btn btn-primary btn-block margin-45-top">
								<span v-if="!form.isLoading">{{ form.button }}</span>
								<span v-if="form.isLoading">
									<div class="center-loader"></div>
								</span>
							</button>												
						</div>					
					</div>
				</div>			
			</fieldset>			
		</form>
	</div><!-- / Form 'well' wrapper -->
</div><!--/ Component container -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{
		props: ['crew', 'project_id'],

		mixins: [api_access],

		data(){
			return{
				formIsLoading: false,
				form: {
					model: 'ProjectUser',
					state: 'create-child',
					title: 'Add Crew',
					button: 'Add',
					action: '/api/projects/add-crew',
					createAction: '/api/projects/add-crew',
					updateAction: '/api/projects/add-crew',
					isLoading: false,					
					successMsg: 'Crew member has been added to project',
					fields: {
						project_id: {val: this.project_id, err: false, dflt: ''},
						user_id: {val: '', err: false, dflt: ''},	
					}
				},
				users: []				
			}
		},

		watch:{
			// Wait for the crew prop to be populated and then turn off loading
			crew(){
				this.formIsLoading = false;
			}
		},

		methods: {
			sendForm(){				
				this.createOrUpdate();
			}
		},

		created(){
			console.log('Crew form-mounted');
			// Hide loader
			if(!this.crew){
				this.isLoading = true;
			}

			if(this.project_id){
				// Store context
				var context = this;
				// Retrieve all users to populate the select list with
				axios.get('/api/users/all')
					.then(function(response){
						;
						// Current project crew
						var currentCrew = [];

						// If there is some current crew
						if(context.crew){
							// Populate current crew
							context.crew.forEach(function(user){
								console.log(user)
								currentCrew.push(user.first + " " + user.last);
							});
						}
	
						// Populate the list of users excluding users already on the crew
						response.data.users.forEach(function(user){
							// If user is not part of the current crew then add to select list
							if(currentCrew.indexOf(user.first + " " + user.last) == -1){
								context.users.push(user);
							}
						});
						
					})
					.catch(function(response){
						console.log(response);
					});
			}			
		}
	}
</script>