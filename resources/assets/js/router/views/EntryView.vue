<template>
    <div class="card" v-if="entry">
        <div class="card-block">
            <h4 class="card-title">{{ title }}</h4>
            <vue-markdown :source="content"></vue-markdown>
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
                    <editor-status-bar
                        :entry="entry"
                        :content="content"
                    ></editor-status-bar>
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
import EditorStatusBar from './../../components/EditorStatusBar.vue';
import DeleteEntryButton from './../../components/Entry/DeleteEntryButton.vue';
import VueMarkdown from 'vue-markdown';

export default {

    props: ['journalId', 'entryId'],

    data() {
        return {
            title: '',
            content: '',
            files: []
        }
    },

    components: {
        VueMarkdown,
        EditorStatusBar,
        DeleteEntryButton,
        FilesBag
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
        entry() {
            // Emit a custom event to trigger decrypt entry content
            // and write title and content to local properties
            if (this.$store.state.entry != null) {
                this.$emit('receivedEntry', this.$store.state.entry);
            }
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