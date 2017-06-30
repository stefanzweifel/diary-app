<template>
    <div>
        <create-entry-button></create-entry-button>
        <hr>

        <div class="card-deck">
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

</template>

<script>
import CreateEntryButton from './../components/Entry/CreateEntryButton.vue';
import Entry from './../components/Entry/Entry.vue';

export default {
    components: {
        Entry,
        CreateEntryButton
    },

    created() {
        this.$store.dispatch('getEntries', this.$route.params.journalId);
    },

    computed: {
        entries () {
            return this.$store.state.entries;
        }
    }
}
</script>