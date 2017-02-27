<template>
    <div class="o-journal-element list-group-item" @click="selectJournal">
        <h4 class="list-group-item-heading">{{ journal.title }}</h4>
        <p class="list-group-item-text">
            Created: {{ journal.created_at }}
        </p>
    </div>
</template>

<script>
    import * as types from '../store/mutation-types.js';

    export default {
        props: ['journal'],

        methods: {
            selectJournal () {
                this.$store.commit(types.SELECT_JOURNAL, this.journal);
                this.$store.dispatch('getEntries');
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

