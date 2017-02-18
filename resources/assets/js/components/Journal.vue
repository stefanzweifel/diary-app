<template>
    <div class="o-journal-element list-group-item" v-on:click="selectJournal">
        <h4 class="list-group-item-heading">{{ journal.title }}</h4>
        <p class="list-group-item-text">
            Created: {{ journal.created_at }}
        </p>
    </div>
</template>

<script>
    export default {

        props: ['journal'],

        mounted() {
            // console.log("Editor Mounted");
        },

        methods: {
            selectJournal () {
                this.$emit('selectJournal', this.journal);
            }
        }
    }
</script>

<style scoped>
    .list-group-item:hover {
        cursor: pointer;
        background-color: #f1f1f1;
    }
</style>

