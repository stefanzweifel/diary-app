<template>
    <div class="card" v-if="entry">
        <div class="card-block">
            <h4 class="card-title">{{ title }}</h4>
            <vue-markdown :source="content"></vue-markdown>

            <hr>
            <files-bag :files="files" :entryId="entryId"></files-bag>
            <files-list :entryId="entryId" :files="files"></files-list>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <router-link :to="{ name: 'entries.editor', params: { journalId: journalId, entryId: entryId }}" class="btn btn-primary" tag="div">
                            Edit
                        </router-link>
                        <delete-entry-button :entryId="entryId" :journalId="journalId"></delete-entry-button>
                    </div>
                </div>
                <div class="col text-right">
                    <!-- <editor-status-bar
                        :entry="entry"
                        :content="content"
                    ></editor-status-bar> -->
                </div>
            </div>

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
import EditorStatusBar from './../../components/EditorStatusBar.vue';
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
        EditorStatusBar,
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