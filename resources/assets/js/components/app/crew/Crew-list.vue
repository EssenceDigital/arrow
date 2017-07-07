<template>
	
<!-- Component container  -->
<div>
	<div class="row row-padded">
		<h3>Project Crew</h3>
	</div>
	<!-- Tool navigation -->
	<div class="row row-padded margin-25-top">
		<button @click="$router.push('crew-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-user"></span> Add Crew Member
		</button>			
	</div>
	<!-- Show alert if no crew in project -->
	<div v-if="crew.length == 0">
		<div class="row row-padded margin-35-top">
			<div class="alert alert-warning text-center">
				<big><strong>Heads up!</strong> No users have been added to the crew. You'll need to add some before they can add timesheets to this project.</big>
			</div>				
		</div>
	</div>
	<!-- crew table in the form of panels -->
	<div v-if="crew.length > 0">
		<div class="row row-padded margin-25-top">
			<h4>Current crew:</h4>			
		</div>

		<div class="row row-padded">
			<div class="col-md-4 margin-25-top"
				v-for="user in crew"
			>
				<div class="bs-component">
					<ul class="list-group">
						<li class="list-group-item">
					
							<button class="btn btn-xs btn-danger pull-right"
								@click="removeCrewFromProject(user.id)"
							>
								<span class="glyphicon glyphicon-minus"></span>
							</button>
		
							{{ user.first + " " + user.last }}
						</li>
					</ul>
				</div>
	      	</div>
	    </div>

	</div><!-- / crew table panels -->																				
</div><!-- / containing div -->

</template>

<script>
	export default{
		// The crew members to populate the list with
		// The parent project id
		props: ['crew', 'project_id'],

		methods: {
			removeCrewFromProject(user_id){
				// Cache context and post object
				var context = this,
					postData = { 
						project_id: this.project_id, 
						user_id: user_id, 
						_token: window.Laravel.csrfToken  
					};
				// Send request to server
				axios.post('/api/projects/remove-crew', postData)
					.then(function(response){
						context.$router.app.$emit('crew-removed', user_id);
						// Clear form, notify, and reset loader
		                 noty({
		                     text: 'Crew member removed from project',
		                     theme: 'defaultTheme',
		                     layout: 'center',
		                     timeout: 650,
		                     closeWith: ['click', 'hover'],
		                     type: 'success'
		                });						
					})
					.catch(function(response){
						console.log(response);
					});
			}
		},

		created(){
			console.log('Crew list created');
			console.log(this.crew);
		}		
	}
</script>