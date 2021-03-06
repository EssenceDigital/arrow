
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
 * Components
 */
const app_hub = require('./components/app/App-hub.vue');

// Dashboard related components
const dashboard_hub = require('./components/app/dashboard/Dashboard-hub.vue');
const dashboard_projects = require('./components/app/dashboard/Dashboard-projects.vue');

// Timesheet related components
const project_timesheets = require('./components/app/timesheet/Project-timesheets.vue');
const timesheets_hub = require('./components/app/timesheet/Timesheets-hub.vue');
const timesheet_search = require('./components/app/timesheet/Timesheet-search.vue');

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

// Crew related components
const crew_list = require('./components/app/crew/Crew-list.vue');
const crew_form = require('./components/app/crew/Crew-form.vue');

// Timeline related components
const timeline_form = require('./components/app/timeline/Timeline-form.vue');
const timeline_table = require('./components/app/timeline/Timeline-table.vue');

// UI components
const navbar = require('./components/app/_ui/Navbar.vue');

Vue.component('app-hub', app_hub);
Vue.component('navbar', navbar);
//Vue.component('users-hub', require('./components/app/Users-hub.vue'));
//Vue.component('user-settings', require('./components/app/User-settings.vue'));

const routes = [
	{
		path: '/dashboard',
		component: dashboard_hub,
		children: [
			{
				path: 'projects',
				component: project_search
			},
			{
				path: 'projects/:project_id/timesheets',
				component: project_timesheets,
				props: true
			}
		]
	},
	// Project related routes
	{ 
		path: '/projects', 
		component: projects_hub,
		children: [
			{ path: 'search', component: project_search },
			{ 
				path: 'view/:project_id', 
				component: project_hub,
				props: true,
				children: [
					{ 
						path: 'hub',
						components: {
							project: project_table,
							crew: crew_list,
							timeline: timeline_table
						},
						props: true
					},
					{
						path: 'options',
						components: {
							project: project_form
						},
						props: true
					},
					{
						path: 'crew-form',
						components: {
							project: project_table,
							crew: crew_form,
							timeline: timeline_table
						}
					},					
					{
						path: 'timeline-form',
						components: {
							project: project_table,
							crew: crew_list,
							timeline: timeline_form
						}
					}					
				]
			},
			{ path: 'create', component: project_form }
		]
	},
	// Timesheets related routes
	{ 
		path: '/timesheets', 
		component: timesheets_hub,
		children: [
			{ path: 'search', component: timesheet_search }
		]
	},
	// User related routes
	{
		path: '/users',
		component: users_hub,
		children: [
			{ path: 'search', component: user_search },
			{ 
				path: 'view/:user_id', 
				component: user_hub,
				props: true,
				children: [
					{ 
						path: 'hub',
						component: user_table,
						props: true
					},
					{
						path: 'options',
						component: user_form,
						props: true
					},					
					{
						path: 'projects/:project_id/timesheets',
						component: project_timesheets,
						props: true
					}
				]
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

