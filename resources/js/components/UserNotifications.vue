<template>
	<div class="dropdown" v-if="notifications.length">
		<button
			class="btn btn-default dropdown-toggle text-danger"
			type="button"
			id="dropdownMenuButton"
			data-toggle="dropdown"
			aria-haspopup="true"
			aria-expanded="false"
		>
			<i class="icon ion-md-globe"></i>
			<span
				class="num-notifications font-size"
				v-text="notifications.length"
			></span>
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a
				class="dropdown-item"
				v-for="notification in notifications"
				:href="notification.data.link"
				@click="markAsRead(notification)"
			>
				{{ notification.data.message }}
			</a>
		</div>
	</div>
</template>

<style>
.dropdown .dropdown-toggle::after {
	content: none;
}

.btn:focus,
.btn.focus {
	outline: 0;
	box-shadow: none;
}

.dropdown.show {
	outline: none;
}

.dropdown .num-notifications {
	position: relative;
	top: 0.75em;
	font-size: 0.75em;
}
</style>

<script>
export default {
	data() {
		return {
			notifications: []
		};
	},
	created() {
		axios
			.get(`/profiles/${window.data.user.id}/notifications`)
			.then(({ data }) => (this.notifications = data))
			.catch(err => console.log);
	},
	methods: {
		markAsRead(notification) {
			axios
				.delete(
					`/profiles/${window.data.user.id}/notifications/${notification.id}`
				)
				.catch(err => console.log);
		}
	}
};
</script>
