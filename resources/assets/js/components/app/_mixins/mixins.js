export default {

	methods: {
		sendForm: function(){
			// Show loader
			this.form.isLoading = true;

			// Populate data to send to server
			var data = {};
			for(var key in this.form.fields){
				data[key] = this.form.fields[key].val;
			}
			// Add token
			data._token = window.Laravel.csrfToken;

			// Cache context
			var context = this;
			console.log(this.form.fields.province.val);

			// Send POST to server
			axios.post('/app/projects/create', data)
				.then(function(response){
					console.log(response);
					// Clear form, notify, and reset loader
	                 noty({
	                     text: 'Project has been created',
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 650,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });						
					context.clearForm();
					context.form.isLoading = false;
				})
				.catch(function(error){
					console.log(error.response.data);
                    if (error.response) {
                        // If the server responded with error data
                        for(var key in error.response.data){
                            context.form.fields[key].msg = error.response.data[key][0];
                            context.form.fields[key].err = true;                                    
                        }
                        // Hide loader
                        context.form.isLoading = false;

                    }
				});				
		}
	}

}