<template>
	<ul class="pagination" v-if="shouldPaginate">
		<li class="page-item" v-show="prevUrl">
			<a
				class="page-link"
				href="#"
				aria-label="Previous"
				rel="prev"
				@click.prevent="page--"
			>
				<span aria-hidden="true">Prev &laquo;</span>
				<span class="sr-only">Previous</span>
			</a>
		</li>

		<li class="page-item" v-for="index in pages" :key="index">
			<span v-if="page == index + 1" v-text="index + 1"></span>
			<a
				v-else
				class="page-link"
				href="#"
				v-text="index + 1"
				@click.prevent="changePage(index + 1)"
			></a>
		</li>

		<li class="page-item" v-show="nextUrl">
			<a
				class="page-link"
				href="#"
				aria-label="Next"
				rel="next"
				@click.prevent="page++"
			>
				<span aria-hidden="true">Next &raquo;</span>
				<span class="sr-only">Next</span>
			</a>
		</li>
	</ul>
</template>

<style>
.page-item > span {
	position: relative;
	display: block;
	padding: 0.5rem 0.75rem;
	margin-left: -1px;
	margin-top: 1px;
	line-height: 1.25;
}
</style>

<script>
export default {
	props: ['dataSet'],
	data() {
		return {
			page: 1,
			pages: [],
			prevUrl: false,
			nextUrl: false
		};
	},
	computed: {
		shouldPaginate() {
			return !!(this.prevUrl || this.nextUrl);
		}
	},
	watch: {
		dataSet() {
			this.page = this.dataSet.current_page;
			this.pages = [...Array(this.dataSet.last_page).keys()];
			this.prevUrl = this.dataSet.prev_page_url;
			this.nextUrl = this.dataSet.next_page_url;
		},
		page() {
			this.broadcast().updateUrl();
		}
	},
	methods: {
		broadcast() {
			return this.$emit('changed', this.page);
		},
		updateUrl() {
			history.pushState(null, null, `?page=${this.page}`);
		},
		changePage(page) {
			this.page = page;
		}
	}
};
</script>
