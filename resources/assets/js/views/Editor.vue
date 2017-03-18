<template>
    <div class="panel panel-default" v-if="entry">
        <div class="panel-body">

            <form @submit.prevent="store">

                <!-- For a weird reason I have to display the encrypted values
                    in order to get the data override to work.
                    Smells like bad code ...
                 -->
                <ul class="hidden">
                    <li>Decrypted Title: <code>{{ decryptedTitle }}</code></li>
                    <li>decrypt content: <code>{{ decryptedContent }}</code></li>
                </ul>

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
                <router-link :to="{ name: 'entries.preview', params: { entryId: entry.id }}" class="btn btn-default btn-sm">Preview</router-link>
                <button @click="store" @keyup.meta.31="store" class="btn btn-success btn-sm">Save</button>
                <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
            </div>

            <!-- <editor-status-bar
                :entry="entry"
                :content="content"
            ></editor-status-bar> -->
        </div>
    </div>
</template>

<script>
import EditorStatusBar from './../components/EditorStatusBar.vue';
import autosize from 'autosize';
import Crypto from './../classes/Crypto.js';

export default {

    components: {
        EditorStatusBar
    },

    data() {
        return {
            title: '',
            content: ''
        }
    },

    mounted() {
        autosize(document.querySelector('textarea'));
        this.$store.dispatch('getEntry', this.$route.params.entryId);
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
        },

        destroy () {
            this.$store.dispatch('deleteEntry', this.$route.params.entryId);
        }

    },

    watch: {
        decryptedTitle: (value) => {
            this.title = value;
        }
    },

    computed: {
        entry() {
            return this.$store.state.entry;
        },

        decryptedTitle() {
            if (this.entry == null) {
                return 'LOADING';
            }

            let crypto = new Crypto(this.$store.state.encryption_password);

            this.title = crypto.decrypt(this.entry.title);

            return crypto.decrypt(this.entry.title);
        },

        decryptedContent() {
            if (this.entry == null) {
                return 'LOADING';
            }

            let crypto = new Crypto(this.$store.state.encryption_password);

            this.content= crypto.decrypt(this.entry.content);

            return crypto.decrypt(this.entry.content);
        }
    }
}
</script>


<style lang="scss" scoped>
    .form-control {
        border: none;
        box-shadow: none;
        padding: 1em;

        // &:focus {
        //     box-shadow: none;
        //     border: none;
        // }
    }
</style>
