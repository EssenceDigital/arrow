<template>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button v-on:click="collapsed = !collapsed" type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">App</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div v-bind:class="{ 'in': !collapsed }" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                
                    <!-- Links go here -->
                    <slot></slot>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <button type="button" class="log-out btn btn-default btn-sm navbar-btn">Log Out</button>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

</template>

<script>
    export default {
        data() {
            return {
                collapsed: true
            }
        }
    }
</script>

<style>
    
    .log-out{
        margin-left: 10px;
    }

</style>
