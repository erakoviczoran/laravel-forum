<template>
	<div>
		<div v-for="(reply, index) in items" :key="index">
			<reply
				:data="reply"
				:index="index"
				@updated="update(index, $event)"
				@deleted="remove(index)"
			></reply>
		</div>

		<div class="row mt-2">
			<div class="col-md-7 offset-1">
				<paginator :dataSet="dataSet" @changed="fetch"></paginator>
			</div>
		</div>

		<new-reply :endpoint="endpoint" @created="add"></new-reply>
	</div>
</template>
<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
import collection from '../mixins/collection';

export default {
	components: { Reply, NewReply },
	mixins: [collection],
	data() {
		return {
			dataSet: false,
			endpoint: location.pathname + '/replies'
		};
	},
	created() {
		this.fetch();
	},
	methods: {
		fetch(page) {
			axios.get(this.url(page)).then(this.refresh);
		},
		url(page) {
			if (!page) {
				let query = location.search.match(/page=(\d+)/);

				page = query ? query[1] : 1;
			}

			return `${location.pathname}/replies?page=${page}`;
    },
		update(index, data) {
			this.items[index].body = data;
		},
		refresh({ data }) {
			this.dataSet = data;
			this.items = data.data;

			window.scrollTo(0, 0);
		}
	}
};
</script>
