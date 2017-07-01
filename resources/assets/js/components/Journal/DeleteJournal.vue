<template>
    <button  @click="destroy" class="btn btn-danger" >Delete Journal</button>
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
