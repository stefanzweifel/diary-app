<template>
    <button @click="destroy" class="bg-red hover:bg-red-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer">Delete</button>
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
