<template>
	
<!-- Component container  -->
<div class="col-md-12">
	<div v-if="!isLoading">
		<div class="col-md-12">
			<h3>Project Timeline / Milestones</h3>
		</div>
		<!-- Tool navigation -->
		<div class="col-md-12 margin-25-top">
			<button v-if="timeline" @click="$router.push('timeline-form')" class="btn btn-default">
				<span class="glyphicon glyphicon-briefcase"></span> Edit Timeline
			</button>	
			<!-- Show the add timeline button if no timeline is yet present -->
			<button v-if="!timeline" @click="$router.push('timeline-form')" class="btn btn-default">
				<span class="glyphicon glyphicon-briefcase"></span> Add Timeline
			</button>		
		</div>
		<!-- Show alert if no timeline in project -->
		<div v-if="!timeline">
			<div class="col-md-12 margin-35-top">
				<div class="alert alert-info">
					<strong>Heads up!</strong> Timeline has not yet been added. Click the button above to get started
				</div>				
			</div>
		</div>
		<!-- timeline table in the form of panels -->
		<div v-if="timeline">

		</div><!-- / timeline table panels -->		
	</div>																		
</div><!-- / containing div -->

</template>

<script>
	
	export default{
		// The timeline to populate the table with
		// The parent project id
		props: ['timeline', 'project_id'],

		data(){
			return{
				// Wait for the data prop to be populated
				isLoading: false
			}
		},

		// Wait for the timeline data prop to be populated and then turn off the loader
		watch:{
			timeline(){
				this.isLoading = false;
			}
		},

		created(){
			console.log('Timeline table created');
			// Show loader if no project cached
			if(!this.timeline){
				this.isLoading = true;
			}
		}		
	}

</script>