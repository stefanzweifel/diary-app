<template>
    <button type="button" @click="destroy" class="btn btn-danger" >Delete</button>
</template>

<script>
export default {

    props: ['journal'],

    methods: {
        destroy () {
            this.$store.dispatch('deleteJournal', this.journal.id);
        }
    }
}
</script>
