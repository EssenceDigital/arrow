<template>
	
<div class="dropdown clearfix" v-bind:class="{'open': isOpen == true}">
	<button v-on:click="isOpen = !isOpen" class="btn btn-sm" type="button">
		Actions
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="#">Edit</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#">Delete</a></li>
	</ul>
</div>

</template>

<script>
	
	export default {
		data(){
			return {
				isOpen: false
			}
		}
	}

</script>