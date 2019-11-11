<template>
  <div class="alert-flash" v-show="show">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">{{ title }}</h4>
      <p>{{ body }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      title: "",
      body: "",
      show: false
    };
  },
  created() {
    if (this.message) {
      this.flash(this.message);
    }

    window.events.$on("flash", message => this.flash(message));
  },
  methods: {
    flash(message) {
      this.body = message;
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
