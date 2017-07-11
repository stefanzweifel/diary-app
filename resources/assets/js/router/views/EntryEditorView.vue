<template>
    <div class="card">
        <div class="card-block">
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
                    @focus="updateTextarea"
                    @input="update"
                    ></textarea>
                </div>

                {{ entry.attributes.id }}

                <files-bag :files="files" :entryId="entryId"></files-bag>

                <div v-for="(file, index) in files" :key="index" class="media">
                    <img :src="file.uri" alt="" class="d-flex mr-3">
                    <div class="media-body">
                        <button class="btn btn-danger" @click.prevent="files.splice(file, 1)">
                            Remove image
                        </button>
                    </div>
                </div>

            </form>
        </div>
        <div class="card-footer">
            <button @click="store" @keyup.meta.31="store" class="btn btn-success">Save</button>
            <delete-entry-button :entryId="entryId" :journalId="journalId"></delete-entry-button>
        </div>
    </div>
</template>

<script>
import autosize from 'autosize';
import Crypto from './../../classes/Crypto.js';
import FilesBag from './../../components/Util/FilesBag.vue';
import DeleteEntryButton from './../../components/Entry/DeleteEntryButton.vue';

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
        FilesBag,
        DeleteEntryButton
    },

    watch: {
        '$route': 'fetchData'
    },


    created() {
        this.fetchData();
        this.$on('receivedEntry', function(entry) {

            console.log(entry.attributes);
            this.updateTextarea();

            this.title = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.title);
            this.content = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.content);
        });
    },

    methods: {

        fetchData () {
            this.$store.dispatch('getEntry', this.entryId);
        },

        updateTextarea() {
            autosize(document.querySelector('textarea'));
        },

        update (e)  {
            this.updateTextarea();
            this.content = e.target.value;
        },

        store () {
            this.$store.dispatch('updateEntry', {
                entryId: this.entry.id,
                title: new Crypto(this.$store.state.encryption_password).encrypt(this.title),
                content: new Crypto(this.$store.state.encryption_password).encrypt(this.content)
            }).then(() => {

                // this.$store.dispatch('getEntries', this.journalId);
                // this.fetchData();
                this.$router.push({
                    name: 'entries.show',
                    params: {
                        journalId: this.journalId,
                        entryId: this.entryId
                    }
                });
            });
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