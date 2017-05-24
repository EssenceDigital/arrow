module.exports = {
	methods: {
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
						console.log(context.searchResults.modelsCurrentPage);
					} else{
						context.searchResults.models = response.data.models;
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