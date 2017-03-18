<template>
    <div class="o-editor panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12">
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
                </div>
            </div>

            <hr>

            <div class="btn-group">
                <button @click="store" @keyup.meta.31="store" class="btn btn-success btn-sm">Save</button>
                <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
            </div>
        </div>
        <div class="panel-footer">
            <editor-status-bar
                :entry="entry"
                :content="content"
            ></editor-status-bar>
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

        data () {
            return {
                title: '',
                content: ''
            }
        },

        mounted() {
            autosize(document.querySelector('textarea'));

            // Decrypt Title and Content and store the encrypted Values inMemory
            let crypto = new Crypto(this.$store.state.encryption_password);
            let title =  crypto.decrypt(
                this.entry.title
            );

            this.title = title;

            let crypto2 = new Crypto(this.$store.state.encryption_password);
            let content =  crypto2.decrypt(
                this.entry.content
            );

            this.content = content;

        },

        created() {
            autosize(document.querySelector('textarea'));
        },

        computed: {
            entry () {
                return this.$store.state.active_entry;
            }
        },

        methods: {
            update (e)  {
                this.content = e.target.value
            },

            destroy () {
                this.$store.dispatch('deleteEntry');
            },

            edit () {
                autosize(document.querySelector('textarea'));
            },

            store () {
                let crypto = new Crypto(this.$store.state.encryption_password);

                this.entry.title = crypto.encrypt(
                    this.title
                )

                this.entry.content = crypto.encrypt(
                    this.content
                )

                this.$store.dispatch('updateEntry', this.entry);

                this.edit_mode = false;
            }
        }
    }
</script>


<style lang="scss" scoped>
    // textarea {
    //   display: inline-block;
    //   width: 100%;
    //   height: 100%;
    //   vertical-align: top;
    //   box-sizing: border-box;
    //   padding: 20px;
    //   border: none;
    //   resize: none;
    //   outline: none;
    //   font-family: 'Monaco', courier, monospace;
    // }
</style>

