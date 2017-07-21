<template>

<div class="container">
    <navbar>
        <li v-bind:class="{ 'active': $route.path.substring(0,10) == '/dashboard' }">
            <router-link to="/dashboard/projects">Dashboard</router-link>
        </li>         
        <li v-bind:class="{ 'active': $route.path.substring(0,6) == '/users' }">
           	<router-link to="/users/search">Users</router-link>
        </li>     
        <li v-bind:class="{ 'active': $route.path.substring(0,9) == '/projects' }">
           	<router-link to="/projects/search">Projects</router-link>
        </li>       
    </navbar>

   <router-view></router-view>
</div>

</template>

<script>
	
</script>