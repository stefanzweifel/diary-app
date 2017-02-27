<template>
    <div class="o-editor panel panel-default">
        <div class="panel-body">
            <textarea :value="entry.content" @input="update"></textarea>

            <hr>

            <button @click="store" @keyup.meta.31="store" class="btn btn-success btn-sm">Save</button>
            <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
        </div>
        <div class="panel-footer">
            <editor-status-bar
                :entry="entry"
            ></editor-status-bar>
        </div>
    </div>
</template>

<script>

    import EditorStatusBar from './EditorStatusBar.vue';
    import marked from 'marked';
    import autosize from 'autosize';

    export default {

        components: {
            'editorStatusBar': EditorStatusBar
        },

        props: ['entry'],

        mounted() {
            autosize(document.querySelector('textarea'));
        },

        computed: {
            compiledMarkdown() {
                return marked(this.entry.content, { sanitize: true })
            }
        },

        methods: {
            update (e)  {
                this.entry.content = e.target.value
            },

            destroy () {
                this.$store.dispatch('deleteEntry');
            },

            store () {
                this.$store.dispatch('updateEntry', this.entry);
            }
        }
    }
</script>


<style lang="scss" scoped>
    .o-editor {
        // background: gray;
    }

    textarea {
      display: inline-block;
      width: 100%;
      height: 100%;
      vertical-align: top;
      box-sizing: border-box;
      padding: 20px;
      border: none;
      resize: none;
      outline: none;
      font-family: 'Monaco', courier, monospace;
    }


</style>

