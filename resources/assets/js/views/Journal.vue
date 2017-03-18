<template>
    <div class="row">
        <div class="col-md-12">
            <div class="o-entry-drawer">
                <button @click="createEmptyEntry" class="btn btn-success btn-block">New entry</button>
                <hr>

                <div class="list-group">
                    <entry
                        v-if="entries.length > 0"
                        v-for="entry in entries"
                        :entry="entry">
                    </entry>
                </div>
                <div v-if="entries && entries.length == 0">
                    <div class="alert alert-info">
                        No Entries for this journal. Create one!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Entry from './../components/Entry.vue';

export default {
    components: {
        Entry,
    },

    created() {
        this.$store.dispatch('getEntries', this.$route.params.journalId);
    },

    computed: {
        entries () {
            return this.$store.state.entries;
        }
    },

    methods: {
        createEmptyEntry () {
            this.$store.dispatch('createNewEntry', this.$route.params.journalId);
        }
    }
}
</script>