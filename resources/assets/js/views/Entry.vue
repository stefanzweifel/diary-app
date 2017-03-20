<template>
    <div class="panel panel-default" v-if="entry">
        <div v-if="editMode == false">
            <div class="panel-heading">{{ title }}</div>
            <div class="panel-body">
                <vue-markdown :source="content"></vue-markdown>
            </div>

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
        <div class="panel-footer">
            <div class="btn-group">
                <button class="btn btn-default btn-sm" @click="editMode = ! editMode">Toggle</button>
                <button v-if="editMode" @click="store" @keyup.meta.31="store" class="btn btn-success btn-sm">Save</button>
                <button v-if="editMode" @click="destroy" class="btn btn-danger btn-sm">Delete</button>
            </div>

            <editor-status-bar
                :entry="entry"
                :content="content"
            ></editor-status-bar>
        </div>
    </div>
    <div v-else>
        <h1>Loading</h1>
    </div>
</template>

<script>
import autosize from 'autosize';
import Crypto from './../classes/Crypto.js';
import EditorStatusBar from './../components/EditorStatusBar.vue';
import VueMarkdown from 'vue-markdown';

export default {
    components: {
        VueMarkdown,
        EditorStatusBar
    },

    created() {
        this.$store.dispatch('getEntry', this.$route.params.entryId);

        this.$on('receivedEntry', function(entry) {
            this.title = new Crypto(this.$store.state.encryption_password).decrypt(entry.title);
            this.content = new Crypto(this.$store.state.encryption_password).decrypt(entry.content);
        });
    },

    data() {
        return {
            editMode: false,
            title: '',
            content: ''
        }
    },

    methods: {

        update (e)  {
            autosize(document.querySelector('textarea'));
            this.content = e.target.value;
        },

        store () {
            this.$store.dispatch('updateEntry', {
                entry: this.entry.id,
                title: new Crypto(this.$store.state.encryption_password).encrypt(this.title),
                content: new Crypto(this.$store.state.encryption_password).encrypt(this.content)
            });

            this.editMode = false;
        },

        destroy () {
            this.$store.dispatch('deleteEntry', this.$route.params.entryId);
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