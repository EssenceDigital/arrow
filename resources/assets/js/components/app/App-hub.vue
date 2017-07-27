<template>
<!-- CENTRAL HUB FOR THE ENTIRE AP
**** HOLDS THE NAVIGATION LINKS AND MAIN ROUTER MOUNT
 -->

 <!-- App container -->
<div class="container">
    <navbar>
        <!-- Nav links -->
        <li v-bind:class="{ 'active': $route.path.substring(0,10) == '/dashboard' }">
            <router-link to="/dashboard/projects">Dashboard</router-link>
        </li>         
        <li 
            v-if="DASHBOARD_AUTH == 'admin'"
            class="{ 'active': $route.path.substring(0,6) == '/users' }">
           	    <router-link to="/users/search">Users</router-link>
        </li>     
        <li 
            v-if="DASHBOARD_AUTH == 'admin'"
            :class="{ 'active': $route.path.substring(0,9) == '/projects' }">
           	<router-link to="/projects/search">Projects</router-link>
        </li>       
    </navbar>

    <!-- Primary router mount (Where primary routes are rendered) -->

    <router-view></router-view>

   

</div> <!-- / App container -->

</template>

<script>
	export default{
        computed: {
          DASHBOARD_AUTH: function () { return DASHBOARD_AUTH }
        }
    }
</script>