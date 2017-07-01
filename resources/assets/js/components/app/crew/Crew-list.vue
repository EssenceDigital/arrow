<template>
	
<!-- Component container  -->
<div class="col-md-12">
	<div class="col-md-12">
		<h3>Project Crew</h3>
	</div>
	<!-- Tool navigation -->
	<div class="col-md-12 margin-25-top">
		<button @click="$router.push('crew-form')" class="btn btn-default">
			<span class="glyphicon glyphicon-briefcase"></span> Add Crew Member
		</button>			
	</div>
	<!-- Show alert if no crew in project -->
	<div v-if="!crew">
		<div class="col-md-12 margin-35-top">
			<div class="alert alert-info">
				<strong>Heads up!</strong> No crew has been added yet! Add some now
			</div>				
		</div>
	</div>
	<!-- crew table in the form of panels -->
	<div v-if="crew">
		<div class="col-md-12 margin-25-top">
			<h4>Current crew:</h4>			
		</div>

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
						
					})
					.catch(function(response){
						console.log(response);
					});
			}
		},

		created(){
			console.log('Crew list created');
		}		
	}
</script>