<template>
    <button @click="createEntry" class="btn btn-success">New entry</button>
</template>

<script>
export default {

    props: ['journalId'],

    methods: {
        createEntry () {
            this.$store.dispatch('createNewEntry', this.journalId);
        }
    }

}
</script>