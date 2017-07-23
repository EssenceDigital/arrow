/* Provides components with some useful methods to access the db.
 *
 * A properly set up 'hub' form should look like:
 	// Containing object
 	form: { 
 		// Each form field should have an object like:
 		field1: { 
 			// The value to bind the form input too
 			val: '', 
 			// Any error returned by the server
 			err: false, 
 			// The default value for the input
 			dftl: '' 
 		},
 		field2: { },
 		field3: { } // And so on...
 	} 
 *
 *
*/
module.exports =  {

	methods: {
		/* Clears a properly set up 'hub' form. See top most comment.
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

		/* Populate data to send to server via POST. Uses a properly set up 'hub' form. See top most comment.
		 * @return Object the assembled object that can be sent via POST
		*/
		populatePostData(){
			var data = {};
			for(var key in this.form.fields){
				data[key] = this.form.fields[key].val;
			}
			// Add CSRF token. Requires Laravel layout to set the token
			data._token = window.Laravel.csrfToken;

			return data;			
		},

		/* Populates a properly set up 'hub' form from a returned Laravel Eloquent model
		*/
		populateFormFromModel(model){
			// Set values in the form.fields data property
			for(var key in this.form.fields){
				this.form.fields[key].val = model[key];
			}			
		},

		/* Executes a GET request to the provided URL param and then runs a callback function
		 * @param String - URL to send GET request too
		 * @param Function - a callback function to execute which has access to the retrieved model
		*/
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

		/* Executes a GET request to the supplied URL or from the urlToFetch variable in the calling components data() method.
		 * The URL should return a Laravel Eloquent pagination result because this method disects that response into
		 * an object in the calling components data() method. That object in the calling component should look like:
		 	searchResults: {	
				models: [],	
				modelsPageTotal: 0,
				modelsCurrentPage: 0,
				modelsPageLinks: { },
				modelsNextPageUrl: '',
				modelsPrevPageUrl: ''					
			}
		 * @param url - String - Optional URL to send GET request too. Overides the urLToFetch variable in the calling component.
		 *				Usually available when the pagination buttons are clicked 
		 * @return sets the searchResults object in the calling components data() method. See above.
		*/
		getAndSetModels(url){
			// Cache
			var context = this;
			// Show loader
			this.fetchingModels = true;

			// Use callers variable or provided url variable for the GET
			if(url){
				var urlToFetch = url;
			} else {
				var urlToFetch = this.urlToFetch;
			}

			// Send GET request to retrieve pagination results
			axios.get(urlToFetch)
				// Success
				.then(function(response){
					// If the response returned a result we can use
					if(response.data.data){
						// Total amount of pages
						var totalPages = response.data.last_page;

						// If there is more than one page
						if(totalPages > 1){
							// Cache the results from the response
							var nextPageUrl = response.data.next_page_url,
								prevPageUrl = response.data.prev_page_url;
							// Cache and create the URLs for the next and prev page buttons
							if(nextPageUrl != null){
								baseUrl = nextPageUrl.substring(0, nextPageUrl.length - 1);
							} else if(prevPageUrl != null){
								baseUrl = prevPageUrl.substring(0, prevPageUrl.length - 1);
							}
							// Cache and create the direct page links
							for(var i = 1; i <= totalPages; i++){
								context.searchResults.modelsPageurls[i] = baseUrl + i;
							}								
						}
						// Cache the pagination in the calling component
						context.searchResults.modelsNextPageUrl = nextPageUrl;
						context.searchResults.modelsPrevPageUrl = prevPageUrl;
						context.searchResults.modelsCurrentPage = response.data.current_page;
						context.searchResults.modelsPageTotal = totalPages;
						// Cache actual result models
						context.searchResults.models = response.data.data;						
					} else{
						console.log(response.data.models);
						// If the response is not a Laravel pagination then only cache the returned array
						context.searchResults.models = response.data.models;
					}
					
					// Hide loader
					context.fetchingModels = false;
				})
				// Error
				.catch(function(response){
					console.log(response);
				});					
		},

		/* Sends a POST request to create or update a resource in storage. Uses a properly set up 'hub' form. See top most comment.
		 * @return emits an event to let the calling component know how to handle the response
		*/
		createOrUpdate(){
			// Show loader
			this.form.isLoading = true;
			// Assemble the POST data
			var data = this.populatePostData(),
				// Cache context
				context = this;

			// Send POST to server
			axios.post(this.form.action, data)
				// Success
				.then(function(response){
					console.log(response);	
					// Hide loader					
					context.form.isLoading = false;
					// Notify the user of success
	                 noty({
	                     text: context.form.successMsg,
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 1200,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });
	                			
					// Emit an event depending on the 'hub' form state
					if(context.form.state == 'create'){
						context.clearForm();
						context.$router.app.$emit(context.form.createEvent, response.data.model);
					} else if(context.form.state == 'edit'){
						context.$router.app.$emit(context.form.updateEvent, response.data.model);
					}

					// Clear any form errors
	                context.clearFormErrors();										
				})
				// Error
				.catch(function(error){
					console.log(error.response);
                    if (error.response) {
                        // If the server responded with an error then disect the response and cache the error message in the
                        // properly set up 'hub' form. See top most comment
                        for(var key in error.response.data){
                            context.form.fields[key].err = error.response.data[key][0];                              
                        }
                        // Hide loader
                        context.form.isLoading = false;
                    }
				});
		},

		/* Updates a single field in the db depending on the action and id params. The calling component should have an object
		 * formulated like:
			editingField: {
				field: '', 
				val: '', 
				err: false
			}	
		 * @param action - String the action to use in the POST request
		 * @param id - Int the primary key of the row to update
		*/
		updateField(action, id){
			// Show loader
			this.fieldIsUpdating = true;
			// Cache needed data
			var context = this,
				postData = {
					id: id,
					_token: window.Laravel.csrfToken						
				};
			// Add updated field and data
			postData.field = this.editingField.field;
			postData[this.editingField.field] = this.editingField.val;

			// Send post request to update the field
			axios.post(action, postData)
				.then(function(response){
					// Let parent know it should update the project model
					context.$router.app.$emit(context.form.updateEvent, response.data.model);
					// Hide loader
					context.fieldIsUpdating = false;
					// Hide form field
					context.fieldIsEditing[context.editingField.field] = false;
					// Notify success
	                 noty({
	                     text: 'Update was successful',
	                     theme: 'defaultTheme',
	                     layout: 'center',
	                     timeout: 1200,
	                     closeWith: ['click', 'hover'],
	                     type: 'success'
	                });						
				})
				.catch(function(error){
                    if (error.response) {
                        // If the server responded with error data then cache the error in the callers editingField object
                        this.editingField.err = error.response.data[key][0];                              
                    }
				});

		},

		deleteChild(id){
			var idToDelete;
			if(id){
				idToDelete = id;
			} else{
				idToDelete = this.form.fields.id.val;
			}
			// Show loader
			this.isDeleting = true;
			// Assemble object for POST
			var data = {
				id: idToDelete,
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
					// Hide loader
					context.isDeleting = false;	
					console.log(response.data.model);
					// Emit even
					context.$router.app.$emit(context.form.deleteEvent, response.data.model);				
				})
				.catch(function(response){
					console.log(response);
				});				
		},

		/* Sends a POST request to delete the specified row from storage. Uses a properly set up 'hub' from. See top most comment.
		 * @return emits an event letting the caller know if the request was successfull
		*/
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
					context.$router.app.$emit(context.deleteEvent);				
				})
				.catch(function(response){
					console.log(response);
				});				
		}

	}
}