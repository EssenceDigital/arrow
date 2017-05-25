
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router';
require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router');
// Add router to vue
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app_hub = require('./components/app/App-hub.vue');

// User related components
const users_hub = require('./components/app/user/Users-hub.vue');
const user_hub = require('./components/app/user/User-hub.vue');
const user_table = require('./components/app/user/User-table.vue');
const user_form = require('./components/app/user/User-form.vue');
const user_search = require('./components/app/user/User-search.vue');
const user_settings = require('./components/app/user/User-settings.vue');

// Project related components
const projects_hub = require('./components/app/project/Projects-hub.vue');
const project_hub = require('./components/app/project/Project-hub.vue');
const project_table = require('./components/app/project/Project-table.vue');
const project_form = require('./components/app/project/Project-form.vue');
const project_search = require('./components/app/project/Project-search.vue');

// Proposal relateld components
const proposal_table = require('./components/app/proposal/Proposal-table.vue');
const proposal_form = require('./components/app/proposal/Proposal-form.vue');

// UI components
const navbar = require('./components/app/_ui/Navbar.vue');

Vue.component('app-hub', app_hub);
Vue.component('navbar', navbar);
//Vue.component('users-hub', require('./components/app/Users-hub.vue'));
//Vue.component('user-settings', require('./components/app/User-settings.vue'));

const routes = [
	// Project related routes
	{ 
		path: '/projects', 
		component: projects_hub,
		children: [
			{ path: 'search', component: project_search },
			{ 
				path: 'view/:id', 
				component: project_hub,
				children: [
					{ 
						path: 'hub',
						components: {
							'project': project_table,
							'proposal': proposal_table
						}
					},
					{
						path: 'edit',
						components: {
							project: project_form,
							proposal: proposal_table
						}
					},
					{
						path: 'proposal-form',
						components: {
							project: project_table,
							proposal: proposal_form
						}
					}
				]
			},
			{ path: 'create', component: project_form }
		]
	},
	// User related routes
	{
		path: '/users',
		component: users_hub,
		children: [
			{ path: 'search', component: user_search },
			{ 
				path: 'view/:id', 
				component: user_hub,
				children: [
					{ 
						path: 'hub',
						components: {
							user: user_table,
						}
					},
					{
						path: 'edit',
						components: {
							user: user_form,

						}
					}				]
			},
			{ path: 'create', component: user_form }			
		]
	},
	{
		path: '/my-settings',
		component: user_settings
	}
];

const router = new VueRouter({
  routes 
});

const app = new Vue({
  router
}).$mount('#app');

