<template>
    <button @click="createEmptyEntry" class="btn btn-success btn-block">New entry</button>
</template>

<script>
export default {

    methods: {
        createEmptyEntry () {
            this.$store.dispatch('createNewEntry', this.$route.params.journalId);
        }
    }

}
</script>