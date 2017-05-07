<template>

<div v-if="modalActive" class="modal active">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button v-on:click="close" type="button" class="close">&times;</button>
				<h4 class="modal-title"><slot name="title"></slot></h4>
			</div>
			<div class="modal-body">
				<slot name="body"></slot>
			</div>
			<div class="modal-footer">
				<slot name="footer"></slot>
			</div>
		</div>
	</div>
</div>

</template>

<script>

	export default{
		props: ['modalActive'],

		methods: {
			close(){
				this.$emit('modal-close', true);
			}
		}
	}

</script>

<style>

	.active {
		display: block;
	}

</style>