<template>
    <div class="row">
        <div class="col-md-4">

            <p v-if="selectedEntry">selectedEntryId: <code>{{ selectedEntry.id }}</code></p>

            <div class="o-entry-drawer">
                <entry
                    v-if="journal || journal.entries > 0"
                    v-for="entry in journal.entries"
                    v-bind:entry="entry"
                    v-on:selectEntry="selectEntry">
                </entry>
                <div v-if="journal.entries == 0">
                    <p>No Entries for this journal. Create one!</p>
                </div>

                <hr>

                <button v-on:click="create" class="btn btn-success">Create new entry</button>
            </div>

        </div>
        <div class="col-md-8">
            <editor
                v-if="selectedEntry"
                v-bind:entry="selectedEntry"
            ></editor>
        </div>
    </div>


</template>

<script>
    import Editor from './Editor.vue';
    import localStorage from 'vue-localstorage';
    import axios from 'axios';
    import Entry from './Entry.vue';

    export default {
        components: {
            'entry': Entry,
            'editor': Editor,
        },
        props: ['journal'],
        data: () => {
            return {
                selectedEntry: null
            }
        },
        methods: {
            selectEntry (entry) {
                this.selectedEntry = entry;
            },
            create () {

                let token = this.$localStorage.get('jwt-token');
                axios.post(`/api/journals/${this.journal.id}/entries`, {}, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then((response) => {
                    console.log(response);
                    this.$emit('EntryCreated');
                })
                .catch((response) => {
                    console.error("An error accoured", response);
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .o-entry-drawer {
    }
</style>
