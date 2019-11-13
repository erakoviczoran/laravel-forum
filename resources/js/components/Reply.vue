<template>
	<div class="row mt-2">
		<div class="col-md-7 offset-1">
			<div class="card">
				<div :id="'reply-' + id" class="card-header d-flex">
					<p class="flex-grow-1">
						<a :href="'/profiles/' + data.user.id">{{ data.user.name }}</a>
						said <span v-text="ago"></span>
					</p>
					<template v-if="signedIn">
						<favorite :data="data"></favorite>
					</template>
				</div>
				<div class="card-body">
					<div class="body">
						<div v-if="editing">
							<textarea
								class="form-control mb-2"
								name="body"
								rows="10"
								v-model="body"
							></textarea>
							<button class="btn btn-primary" @click="update">Update</button>
							<button class="btn btn-link" @click="editing = false">
								Cancel
							</button>
						</div>
						<div v-else v-text="body"></div>
					</div>
				</div>
				<div class="card-footer" v-if="canUpdate">
					<div class="d-flex">
						<button
							@click="editing = true"
							class="btn btn-outline-secondary btn-sm mr-2"
						>
							Edit
						</button>
						<button
							type="submit"
							@click="destroy"
							class="btn btn-danger btn-sm"
						>
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';
import Favorite from './Favorite.vue';

export default {
	props: ['data'],
	components: { Favorite },
	data() {
		return {
			id: this.data.id,
			body: this.data.body,
			editing: false
		};
	},
	computed: {
		ago() {
			return moment(this.data.created_at).fromNow() + '...';
		},
		signedIn() {
			return window.data.signedIn;
		},
		canUpdate() {
			return this.authorize(user => this.data.user_id == user.id);
		}
	},
	methods: {
		update() {
			axios.patch('/replies/' + this.data.id, {
				body: this.body
			});

			this.editing = false;

			flash('Reply updated!');
		},
		destroy() {
			axios.delete('/replies/' + this.data.id).catch(e => console.log);

			this.$emit('deleted', this.data.id);
		}
	}
};
</script>
