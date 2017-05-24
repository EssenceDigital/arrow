<template>

    <!-- Container -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button @click="collapsed = !collapsed" type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">App</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div :class="{ 'in': !collapsed }" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                
                    <!-- Links go here -->
                    <slot></slot>

                </ul>
                <ul class="nav navbar-nav navbar-right margin-10-top">
                    <li>
                        <dropdown :title="user_name">
                            <li>
                            <router-link to="/my-settings">
                                Settings
                            </router-link>
                            <li class="divider"></li>
                            <li>
                                <form method="post" action="/logout">
                                    <input type="hidden" name="_token" :value="csrfToken">
                                    <button type="submit" class="log-out btn btn-default btn-sm">Log Out</button>
                                </form>                                 
                            </li>                                
                        </dropdown>                       
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav><!-- / Container -->

</template>

<script>
    let dropdown = require('./../_ui/Dropdown.vue');

    export default {
        components: {
            'Dropdown': dropdown
        },

        data() {
            return {
                collapsed: true,
                csrfToken: window.Laravel.csrfToken,
                user_name: DASHBOARD_USERS_NAME
            }
        }
    }
</script>

<style>
    
    .log-out{
        margin-left: 10px;
    }

</style>
