module.exports =  {

	methods: {
		// Shows the view all models tab and clears the form
		viewAllModelsTab(){
			this.currentTab = 'view-all';
			this.getAndSetModels(this.urlToFetch);
		},

		// Shows the user form tab and clears out the form
		viewFormTab(){
			// Set tab
			this.currentTab = 'view-form';
		},

		viewModelAsTable(){
			// Set tab
			this.currentTab = 'view-table';			
		},

		grabLocalModel(id){
			var gabbedModel = [];
			// Find model
			this.models.forEach(function(model){
				if(model.id == id) {
					grabbedModel = model;
				}
			});
			return grabbedModel;			
		},

		grabModelFromServer(url, cb){
			var context = this;
			// Send request
			axios.get(url)
				.then(function(response){
					console.log(response.data.model);
					context.selectedModel = response.data.model;
					cb.call(context);
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
								context.modelsPageLinks[i] = baseUrl + i;
							}								
						}

						context.modelsNextPageUrl = nextPageUrl;
						context.modelsPrevPageUrl = prevPageUrl;
						context.modelsCurrentPage = response.data.current_page;
						context.modelsPageTotal = totalPages;
						// Set data prop
						context.models = response.data.data;						
						console.log(context.modelsCurrentPage);
					} else{
						context.models = response.data.models;
					}
					
					// Hide loader
					context.fetchingModels = false;
				})
				.catch(function(response){
					console.log(response);
				});					
		}




	}

}