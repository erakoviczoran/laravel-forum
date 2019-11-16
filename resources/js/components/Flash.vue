<template>
	<div class="alert-flash" v-show="show">
		<div class="alert" :class="'alert-' + level" role="alert">
			<h4 class="alert-heading">{{ title }}</h4>
			<p>{{ body }}</p>
		</div>
	</div>
</template>

<script>
export default {
	props: ['message'],
	data() {
		return {
			title: '',
			body: '',
			level: 'success',
			show: false
		};
	},
	created() {
		if (this.message) {
			this.flash(this.message);
		}

		window.events.$on('flash', data => this.flash(data));
	},
	methods: {
		flash(data) {
			this.body = data.message;
			this.level = data.level;
			this.show = true;

			this.hide();
		},
		hide() {
			setTimeout(() => {
				this.show = false;
			}, 3000);
		}
	}
};
</script>

<style>
.alert-flash {
	position: fixed;
	right: 20px;
	bottom: 20px;
	z-index: 1000;
}
</style>
