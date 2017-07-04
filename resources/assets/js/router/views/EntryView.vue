<template>
    <div class="card" v-if="entry">
        <div class="card-block">
            <div v-if="editMode == false">
                <h4 class="card-title">{{ title }}</h4>
                <vue-markdown :source="content"></vue-markdown>
            </div>
            <div v-else>

                <form @submit.prevent="store">
                    <div class="form-group">
                        <input
                            type="text"
                            v-model="title"
                            placeholder="This is the title of your entry"
                            class="form-control"
                        >
                    </div>
                    <div class="form-group">
                        <textarea
                            :value="content"
                            placeholder="The content of your entry. **Markdown** is *supported*!"
                            class="form-control"
                            @input="update"
                        ></textarea>
                    </div>
                </form>

            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <button class="btn btn-primary" v-if="!editMode" @click="toggle">Edit</button>
                        <button class="btn btn-default" v-if="editMode" @click="toggle">Cancel</button>
                        <button v-if="editMode" @click="store" @keyup.meta.31="store" class="btn btn-success">Save</button>
                        <delete-entry-button :entryId="entryId" :journalId="journalId"></delete-entry-button>
                    </div>
                </div>
                <div class="col text-right" v-if="editMode == false">
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
import autosize from 'autosize';
import Crypto from './../../classes/Crypto.js';
import EditorStatusBar from './../../components/EditorStatusBar.vue';
import DeleteEntryButton from './../../components/Entry/DeleteEntryButton.vue';
import VueMarkdown from 'vue-markdown';

export default {

    props: ['journalId', 'entryId'],

    data() {
        return {
            editMode: false,
            title: '',
            content: ''
        }
    },

    components: {
        VueMarkdown,
        EditorStatusBar,
        DeleteEntryButton
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
        },

        update (e)  {
            autosize(document.querySelector('textarea'));
            this.content = e.target.value;
        },

        store () {
            this.$store.dispatch('updateEntry', {
                entryId: this.entry.id,
                title: new Crypto(this.$store.state.encryption_password).encrypt(this.title),
                content: new Crypto(this.$store.state.encryption_password).encrypt(this.content)
            }).then(() => {
                this.$store.dispatch('getEntries', this.journalId);
                this.$store.dispatch('getEntry', this.entryId);
            });

            this.editMode = false;
        },

        toggle() {
            this.editMode = ! this.editMode;
            autosize(document.querySelector('textarea'));
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
        min-height: 400px;
    }
</style>