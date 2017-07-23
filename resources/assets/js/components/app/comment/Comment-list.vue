<template>

<!-- Component container -->
<div>
	<h3>Notes</h3>

    <div v-for="comment in comments" class="margin-25-top">
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left meta">
                    <div class="title h5">
                        <a href="#"><b>{{ comment.user.first + ' ' + comment.user.last }}</b></a>
                       	added a note.
                    </div>
                    <h6 class="text-muted time">{{ comment.date }}</h6>
                </div>
                <div class="pull-right meta">
			    	<dropdown v-bind:title="'Actions'">
						<li v-if="comment.user.id == loggedInUserId">
							<a @click="removeNote(comment.id)">Remove</a>
						</li>
			    	</dropdown>		                

                </div>
        	</div> 
            <div class="post-description"> 
                <p>
                	{{ comment.comment }}
                </p>
            </div>
        </div>
    </div>
</div><!-- / Component container -->

</template>

<script>
	let dropdown = require('./../_ui/Dropdown.vue');

	export default{
		components: {
			dropdown
		},	

		// The comments to populate the list with
		// The parent project id
		props: ['comments', 'project_id'],

		data(){
			return{
				loggedInUserId: DASHBOARD_USER_ID
			}
		},

		methods: {
			removeNote(comment_id){
				// Cache context and post object
				var context = this,
					postData = { 
						comment_id: comment_id, 
						_token: window.Laravel.csrfToken  
					};
				// Send request to server
				axios.post('/api/projects/remove-comment', postData)
					.then(function(response){
						context.$router.app.$emit('comment-removed', comment_id);
						// Clear form, notify, and reset loader
		                 noty({
		                     text: 'Comment removed from project',
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
			console.log('Comment list created');
			console.log(this.comments);
		}		
	}

</script>