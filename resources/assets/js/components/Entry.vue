<template>
    <div
        class="o-journal-element list-group-item"
        v-on:click="selectEntry"
        v-bind:class="{ active: isActive }"
    >
        <p class="list-group-item-text">
            <p>{{ entry.content }}</p>

            <i>{{formatedDate }}</i>
        </p>
    </div>
</template>

<script>
    import moment from 'moment';
    import * as types from '../store/mutation-types.js';

    export default {

        props: ['entry'],

        computed: {
            isActive () {
                if (this.active_entry) {
                    return this.entry.id == this.active_entry.id;
                }
                return false;
            },

            active_entry () {
                return this.$store.state.active_entry;
            },

            formatedDate () {
                return moment(this.entry.created_at).format();
            }
        },

        methods: {
            selectEntry () {
                this.$store.commit(types.SELECT_ENTRY, this.entry);
            }
        }
    }
</script>

<style scoped>
    .list-group-item:hover {
        cursor: pointer;
        /*background-color: #f1f1f1;*/
    }
</style>

