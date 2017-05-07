<template>
	
<div class="dropdown clearfix" v-bind:class="{'open': isOpen == true}">
	<button v-on:click="isOpen = !isOpen" class="btn btn-sm" type="button">
		Actions
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<slot></slot>
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