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
		formEditState(stateName){
			this.form.state = stateName;
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

		grabModel(url, cb){
			var context = this;
			// Send request
			axios.get(url)
				.then(function(response){
					cb.call(context, response.data.model);
				})
				.catch(function(response){
					console.log(response);
				});				

		},

		// Sends a GET request to retrieve all projects from the server then sets the projects data prop
		getAndSetModels(link){
			var context = this;
			// Show loader
			this.fetchingModels = true;

			if(link){
				var urlToFetch = link;
			} else {
				var urlToFetch = this.urlToFetch;
			}
			// Send request
			axios.get(urlToFetch)
				.then(function(response){
					console.log(response);
					
					if(response.data.data){
						var totalPages = response.data.last_page;

						if(totalPages > 1){
							var nextPageUrl = response.data.next_page_url,
								prevPageUrl = response.data.prev_page_url;

							if(nextPageUrl != null){
								baseUrl = nextPageUrl.substring(0, nextPageUrl.length - 1);
							} else if(prevPageUrl != null){
								baseUrl = prevPageUrl.substring(0, prevPageUrl.length - 1);
							}

							for(var i = 1; i <= totalPages; i++){
								context.searchResults.modelsPageLinks[i] = baseUrl + i;
							}								
						}

						context.searchResults.modelsNextPageUrl = nextPageUrl;
						context.searchResults.modelsPrevPageUrl = prevPageUrl;
						context.searchResults.modelsCurrentPage = response.data.current_page;
						context.searchResults.modelsPageTotal = totalPages;
						// Set data prop
						context.searchResults.models = response.data.data;						
					} else{
						context.searchResults.models = response.data.models;
					}
					
					// Hide loader
					context.fetchingModels = false;
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
	                     timeout: 1200,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });

	                			
					// Show next content dependingo on form state
					if(context.form.state == 'create'){
						context.clearForm();
						context.$router.app.$emit('model-created', response.data.model);
					} else if(context.form.state == 'edit'){
						context.$router.app.$emit('model-updated', response.data.model);
					} else if(context.form.state == 'create-child'){
						context.$router.app.$emit('child-created', response.data.model);
					} else if(context.form.state == 'edit-child'){
						context.$router.app.$emit('child-created', response.data.model);
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
					context.$router.app.$emit('model-deleted');				
				})
				.catch(function(response){
					console.log(response);
				});				
		}

	}

}