<template>
	<button :class="classes" @click="subscribe">
		Subscribe
	</button>
</template>

<script>
export default {
	props: ['active'],
	data() {
		return {
			isActive: this.active
		};
	},
	computed: {
		classes() {
			return ['btn', this.isActive ? 'btn-primary' : 'btn-outline-secondary'];
		}
	},
	methods: {
		subscribe() {
			axios[this.isActive ? 'delete' : 'post'](
				location.pathname + '/subscriptions'
			)
				.then(data => {
					this.isActive = !this.isActive;
				})
				.catch(err => console.log);
		}
	}
};
</script>
