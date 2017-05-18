module.exports =  {

	methods: {
		/* Clears a properly set up 'hub' form. Data value should look like:
		 * form: { field: { val: '', err: false, dftl: '' } } 
		 * dftl should be default initial value 
		*/
		clearForm(){
			for(var key in this.form.fields){
				this.form.fields[key].val = this.form.fields[key].dflt;
			}
		},

		// Clears the errors on a properly set up 'hub' form. See above comments
		clearFormErrors(){
			for(var key in this.form.fields){
				this.form.fields[key].err = false;
			}			
		},

		// Sets the form state and titles for a create
		formNewState(){
			this.form.state = 'create';
			this.form.title = 'Create ' + this.form.model;
			this.form.button = 'Save';
			this.form.action = this.form.createAction;
			this.form.successMsg = this.form.model + ' has been saved'
		},

		// Sets the form state titles for an edit
		formEditState(){
			this.form.state = 'edit';
			this.form.title = 'Edit ' + this.form.model;
			this.form.button = 'Update';
			this.form.action = this.form.updateAction;
			this.form.successMsg = this.form.model + ' has been updated'
		},

		// Populate data to send to server via POST. Uses a properly set up 'hub' form. See above comments
		populatePostData(){
			var data = {};
			for(var key in this.form.fields){
				data[key] = this.form.fields[key].val;
			}
			// Add CSRF token. Requires Laravel layout to set the token
			data._token = window.Laravel.csrfToken;

			return data;			
		},

		populateFormFromModel(model){
			// Set values in the form.fields data property
			for(var key in this.form.fields){
				this.form.fields[key].val = model[key];
			}			
		},

		grabModelFromServer(url, cb){
			var context = this;
			// Send request
			axios.get(url)
				.then(function(response){
					context.selectedModel = response.data.model;
					cb.call(context);
				})
				.catch(function(response){
					console.log(response);
				});				

		},

		/* Sends a POST request to create or update a resource in storage. Uses a properly
		 * set up 'hub' form. See above comments
		*/
		createOrUpdate(){
			// Show loader
			this.form.isLoading = true;

			var data = this.populatePostData();

			// Cache context
			var context = this;

			// Send POST to server
			axios.post(this.form.action, data)
				.then(function(response){
					console.log(response);						
					context.form.isLoading = false;
					// Clear form, notify, and reset loader
	                 noty({
	                     text: context.form.successMsg,
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 650,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });					
					// Show next content dependingo on form state
					if(context.form.state == 'create'){
						context.clearForm();
						context.$emit('created', response.data.model);
					} else if(context.form.state == 'create-child'){
						context.$emit('created', response.data.model);
					}

					// Clear any form errors
	                context.clearFormErrors();										
				})
				.catch(function(error){
					console.log(error.response);
                    if (error.response) {
                        // If the server responded with error data
                        for(var key in error.response.data){
                            context.form.fields[key].err = error.response.data[key][0];                              
                        }
                        // Hide loader
                        context.form.isLoading = false;
                    }
				});
		},

		// Sends a POST request to delete the specified and confirmed model
		deleteModel(){
			// Show loader
			this.isDeleting = true;
			// Assemble object for POST
			var data = {
				id: this.form.fields.id.val,
				_token: window.Laravel.csrfToken
			};
			// Store context
			var context = this;
			// Send GET request to delete
			axios.post(this.urlToDelete, data)
				.then(function(response){
					// Notify
	                 noty({
	                     text: context.form.model + ' has been deleted',
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 850,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });
	                // Close modal and show all users						
					context.modalActive = false;
					// Hide loader
					context.isDeleting = false;	
					// Emit even
					context.$emit('deleted', true);				
				})
				.catch(function(response){
					console.log(response);
				});				
		}

	}

}