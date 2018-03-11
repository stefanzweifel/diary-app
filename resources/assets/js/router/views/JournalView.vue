<template>
    <div class="flex">
        <div class="h-screen bg-white flex flex-col w-1/2 border-r">

            <div class="p-4 border-b shadow z-10">
                <create-entry-button :journalId="journalId" v-if="entries && entries.length > 0" />
                <delete-journal :journalId="journalId" />
            </div>

            <div class="bg-grey-lightest flex-grow overflow-scroll">
                <div v-if="entries && entries.length == 0">
                    <div class="text-center p-4 rounded mt-2">
                        <p class="mb-4 text-grey-dark">No entries for this journal</p>
                        <create-entry-button :journalId="journalId" />
                    </div>
                </div>
                <entry
                    v-if="entries.length > 0"
                    v-for="entry in entries"
                    :key="entry.id"
                    :entry="entry">
                </entry>
            </div>
        </div>
        <div class="md:w-full" v-if="entries && entries.length > 0">
            <router-view></router-view>
        </div>
        <div v-else class="flex justify-center items-center w-full">
            <p class="text-grey text-3xl italic">Create a new entry or select an existing one</p>
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
