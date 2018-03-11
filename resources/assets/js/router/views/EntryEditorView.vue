<template>
    <div class="h-screen bg-white flex flex-col">
        <div class="p-4 border-b shadow text-right">
            <button @click="store" @keyup.meta.31="store" class="bg-green hover:bg-green-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer">Save</button>
            <delete-entry-button :entryId="entryId" :journalId="journalId"></delete-entry-button>
        </div>
        <div class="p-8 flex-grow overflow-scroll">
            <form @submit.prevent="store">
                <div class="mb-4">
                    <input
                        type="text"
                        v-model="title"
                        placeholder="This is the title of your entry"
                        class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker w-full"
                    >
                </div>
                <div class="form-group">
                    <textarea
                    :value="content"
                    rows="10"
                    placeholder="The content of your entry. **Markdown** is *supported*!"
                    class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker w-full"
                    @focus="updateSizeOfTextarea"
                    @input="update"
                    ></textarea>
                </div>

                {{ entry.attributes.id }}

                <files-list :files="files" :entryId="entryId"></files-list>
            </form>
        </div>
        <div class="p-4 border-t">
            <files-bag :files="files" :entryId="entryId"></files-bag>
        </div>
    </div>
</template>

<script>
import autosize from 'autosize';
import Crypto from './../../classes/Crypto.js';
import FilesBag from './../../components/Util/FilesBag.vue';
import FilesList from './../../components/Util/FilesList.vue';
import DeleteEntryButton from './../../components/Entry/DeleteEntryButton.vue';

export default {

    props: ['journalId', 'entryId'],

    data() {
        return {
            title: '',
            content: ''
        }
    },

    components: {
        FilesBag,
        FilesList,
        DeleteEntryButton
    },

    watch: {
        '$route': 'fetchData'
    },


    created() {
        this.fetchData();
        this.$on('receivedEntry', function(entry) {
            this.updateSizeOfTextarea();

            this.title = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.title);
            this.content = new Crypto(this.$store.state.encryption_password).decrypt(entry.attributes.content);
        });
    },

    methods: {

        fetchData () {
            this.$store.dispatch('getEntry', this.entryId);
            this.$store.dispatch('getMedia', this.entryId);
        },

        updateSizeOfTextarea() {
            autosize(document.querySelector('textarea'));
        },

        update (e)  {
            this.updateSizeOfTextarea();
            this.content = e.target.value;
        },

        store () {
            this.$store.dispatch('updateEntry', {
                entryId: this.entry.id,
                title: new Crypto(this.$store.state.encryption_password).encrypt(this.title),
                content: new Crypto(this.$store.state.encryption_password).encrypt(this.content)
            }).then(() => {

                this.$store.dispatch('getEntry', this.entryId);
                this.$store.dispatch('getEntries', this.journalId);
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

        files() {
            return this.$store.state.files;
        },

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
