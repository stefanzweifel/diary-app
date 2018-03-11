<template>
    <div class="h-screen bg-white flex flex-col" v-if="entry">
        <div class="p-4 border-b shadow text-right">
            <router-link :to="{ name: 'entries.editor', params: { journalId: journalId, entryId: entryId }}" class="bg-blue hover:bg-blue-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer" tag="div">
                Edit
            </router-link>
            <delete-entry-button :entryId="entryId" :journalId="journalId"></delete-entry-button>
        </div>
        <div class="p-8 flex-grow overflow-scroll">
            <h1 class="font-bold mb-2">{{ title }}</h1>
            <vue-markdown :source="content" class="leading-normal text-lg"></vue-markdown>

            <div class="border-t pt-4 mt-4">
                <files-list :entryId="entryId" :files="files"></files-list>
            </div>
        </div>
        <div class="p-4 border-t">
            <files-bag :files="files" :entryId="entryId"></files-bag>
        </div>
    </div>
    <div v-else>
        <h1>Loading</h1>
    </div>
</template>

<script>
import Crypto from './../../classes/Crypto.js';
import FilesBag from './../../components/Util/FilesBag.vue';
import FilesList from './../../components/Util/FilesList.vue';
import DeleteEntryButton from './../../components/Entry/DeleteEntryButton.vue';
import VueMarkdown from 'vue-markdown';

export default {

    props: ['journalId', 'entryId'],

    data() {
        return {
            title: '',
            content: ''
        }
    },

    components: {
        VueMarkdown,
        DeleteEntryButton,
        FilesBag,
        FilesList
    },

    created() {
        this.fetchData();
        this.$on('receivedEntry', function(entry) {
            this.title = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.title);
            this.content = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.content);
        });
    },

    watch: {
        '$route': 'fetchData'
    },

    methods: {
        fetchData () {
            this.$store.dispatch('getEntry', this.entryId);
        }
    },

    computed: {

        files() {
            return this.$store.state.files;
        },

        entry() {
            // Emit a custom event to trigger decrypt entry content
            // and write title and content to local properties
            if (this.$store.state.entry != null) {
                this.$emit('receivedEntry', this.$store.state.entry);
            }

            this.$store.dispatch('getMedia', this.entryId);

            return this.$store.state.entry;
        }
    }

}
</script>

<style scoped>
    textarea {
        min-height: 200px;
    }

    .media img {
        height: 150px;
    }

</style>
