<template>
	<div>
		<div class="row mt-3" v-if="signedIn">
			<div class="col-md-7 offset-1">
				<textarea
					class="form-control"
					name="body"
					id=""
					rows="5"
					v-model="body"
					required
				></textarea>
				<input
					type="submit"
					class="btn btn-primary mt-2"
					value="Post"
					@click="addReply"
				/>
			</div>
		</div>
		<div class="row justify-content-center mt-2" v-else>
			<p class="col-md-8">
				Please <a href="/login">sign in</a> to participate in this discussion.
			</p>
		</div>
	</div>
</template>

<script>
export default {
	props: ['endpoint'],
	data() {
		return {
			body: ''
		};
	},
	computed: {
		signedIn() {
			return window.data.signedIn;
		}
	},
	methods: {
		addReply() {
			axios.post(this.endpoint, { body: this.body }).then(({ data }) => {
				this.body = '';

				flash('Your reply has been posted.');

				this.$emit('created', data);
			});
		}
	}
};
</script>
