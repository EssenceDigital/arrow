<template>

<!-- Containing div -->
<div>
	<!-- Mount for user table and form -->
	<router-view name="user"
		:user="user">			
	</router-view>
										
</div><!-- / containing div -->

</template>

<script>
	let api_access = require('./../_mixins/api-access.js');

	export default{

		mixins: [api_access],

		data(){
			return{
				user: { },
			}
		},

		methods: {

		},

		// If an id is in the route then retrieve the model from server
		created(){
			console.log('User hub created');

			if(this.$route.params.id){
				// Get a fresh version of the requested model
				this.grabModel('/api/users/' + this.$route.params.id, function(model){
					// Cache retrieved model
					this.user = model;
				});
			}

			// When the form component alerts this parent of a successful updated
			this.$router.app.$on('user-updated', model => {
				// Update cached model
				this.user = model;			
			});	
										
		}
	}
	
</script>