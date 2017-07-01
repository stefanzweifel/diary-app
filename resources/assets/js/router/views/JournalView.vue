<template>
    <div>
        <div class="row">

            <div class="col">

                <div class="btn-group">
                    <create-entry-button :journalId="journalId" v-if="entries && entries.length > 0"></create-entry-button>
                    <delete-journal :journalId="journalId"></delete-journal>
                </div>


                <div v-if="entries && entries.length == 0">
                    <div class="alert alert-info">
                        No Entries for this journal. Create one!

                        <create-entry-button :journalId="journalId"></create-entry-button>
                    </div>
                </div>

                <div class="list-group">
                    <entry
                        v-if="entries.length > 0"
                        v-for="entry in entries"
                        :key="entry.id"
                        :entry="entry">
                    </entry>
                </div>


            </div>
            <div class="col col-md-9" v-if="entries && entries.length > 0">
                <router-view></router-view>
            </div>
        </div>


    </div>

</template>

<script>
import CreateEntryButton from './../../components/Entry/CreateEntryButton.vue';
import Entry from './../../components/Entry/Entry.vue';
import DeleteJournal from './../../components/Journal/DeleteJournal.vue';

export default {

    props: ['journalId'],

    components: {
        Entry,
        CreateEntryButton,
        DeleteJournal
    },

    created() {
        this.fetchData();
    },

    watch: {
        // call again the method if the route changes
        '$route': 'fetchData'
    },

    methods: {
        fetchData() {
            this.$store.dispatch('getEntries', this.journalId);
        }
    },

    computed: {
        entries () {
            return this.$store.state.entries;
        }
    }
}
</script>