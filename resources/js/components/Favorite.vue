<template>
	<button :class="classes" @click="toggle">
		<i class="icon ion-md-heart"></i>
		<span v-text="count"></span>
	</button>
</template>
<script>
export default {
	props: ['data'],
	data() {
		return {
			count: this.data.favoritesCount,
			active: this.data.isFavorited
		};
	},
	computed: {
		classes() {
			return [
				'btn',
				this.active ? 'btn-primary' : 'btn-outline-secondary'
			];
		},
		favoriteUrl() {
			return '/replies/' + this.data.id + '/favorites';
		}
	},
	methods: {
		toggle() {
			return this.active ? this.delete() : this.store();
		},
		store() {
			axios.post(this.favoriteUrl).catch(err => console.log);

			this.active = true;
			this.count++;
		},
		delete() {
			axios.delete(this.favoriteUrl).catch(err => console.log);

			this.active = false;
			this.count--;
		}
	}
};
</script>
