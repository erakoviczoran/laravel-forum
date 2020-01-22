<template>
  <div>
    <div class="d-flex mb-2">
      <img :src="avatar" class="mr-2" width="50" height="50">
      <h1 v-text="user.name"></h1>
    </div>

    <form v-if="canUpdate" method="post" enctype="multipart/form-data">
      <image-upload name="avatar" @loaded="onLoad"></image-upload>
    </form>
  </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],
        components: {ImageUpload},
        data() {
            return {
                avatar: this.user.avatar_path
            };
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },
        methods: {
            onLoad({src, file}) {
                this.avatar = src;
                this.persist(file);
            },
            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.id}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'))
                    .catch(e => console.log(e));
            }
        }
    }
</script>

<style scoped>

</style>
