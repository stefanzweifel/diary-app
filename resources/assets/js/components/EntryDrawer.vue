<template>
    <div class="row">
        <div class="col-md-4">
            <div class="o-entry-drawer">
                <button @click="create" class="btn btn-success">Create new entry</button>
                <hr>
                <div class="list-group">
                    <entry
                        v-if="journal || entries > 0"
                        v-for="entry in entries"
                        :entry="entry">
                    </entry>
                </div>
                <div v-if="entries == 0">

                    <div class="alert alert-info">
                        No Entries for this journal. Create one!
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <editor
                v-if="selectedEntry"
            ></editor>
        </div>
    </div>


</template>

<script>
    import Editor from './Editor.vue';
    import Entry from './Entry.vue';

    import * as types from '../store/mutation-types.js';

    export default {
        components: {
            'entry': Entry,
            'editor': Editor,
        },
        props: ['journal'],

        computed: {
            entries () {
                return this.$store.state.entries;
            },

            selectedEntry () {
                return this.$store.state.active_entry;
            }
        },

        methods: {
            create () {
                this.$store.dispatch('createNewEntry');
            }
        }
    }
</script>

<style lang="scss" scoped>
    .o-entry-drawer {
    }
</style>
