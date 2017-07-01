<template>
    <button @click="destroy" class="btn btn-danger">Delete</button>
</template>

<script>
export default {

    props: ['entryId', 'journalId'],

    methods: {
        destroy () {
            this.$store.dispatch('deleteEntry', this.entryId).then(() => {
                this.$store.dispatch('getEntries', this.journalId);

                let journalId = this.journalId;
                this.$router.push({ name: 'journals.show', params: { journalId }});
            });
        }
    }
}
</script>