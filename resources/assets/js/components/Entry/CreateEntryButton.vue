<template>
    <button @click="createEntry" class="bg-green hover:bg-green-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer">New entry</button>
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
