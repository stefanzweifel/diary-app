<template>
    <div>
        <div v-if="files.length > 0" v-for="file in files" :key="file.id" class="media mb-1">
            <img :src="file.attributes.url" alt="" class="d-flex mr-3">
            <div class="media-body">
                <h6 class="mt-0">{{ file.attributes.name }}</h6>
                <p>
                    <small>Added {{ file.attributes.created_at }}</small>
                </p>

                <button type="button" @click="destroy(file.id)" class="btn btn-danger btn-sm">Delete File</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['entryId', 'files'],

    methods: {

        destroy(mediaId) {

            this.$store.dispatch('deleteMedia', {
                entryId: this.entryId,
                mediaId,
            }).then(() => {
                // And Remove from current Files Array
                this.$store.dispatch('getMedia', this.entryId);
            });
        }

    }

}
</script>

<style scoped>
    img {
        max-width: 250px;
    }
</style>