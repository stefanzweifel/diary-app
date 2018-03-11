<template>
    <button  @click="destroy" class="bg-red hover:bg-red-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer" >Delete Journal</button>
</template>

<script>
export default {

    props: ['journalId'],

    methods: {
        destroy () {
            this.$store.dispatch('deleteJournal', this.journalId);
        }
    }
}
</script>
