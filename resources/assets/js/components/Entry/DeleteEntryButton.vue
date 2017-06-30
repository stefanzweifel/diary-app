<template>
    <button @click="destroy" class="btn btn-danger">Delete</button>
</template>

<script>
export default {

    methods: {
        destroy () {
            this.$store.dispatch('deleteEntry', this.$route.params.entryId);
        }
    }
}
</script>