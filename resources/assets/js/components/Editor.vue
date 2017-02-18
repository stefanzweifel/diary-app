<template>
    <div class="o-editor panel panel-default">
        <div class="panel-heading">
            Currently editing: <code>{{ entry.id }}</code>
        </div>
        <div class="panel-body">
            <textarea :value="entry.content" @input="update"></textarea>

            <!-- Preview -->
            <div v-html="compiledMarkdown"></div>

            <button v-on:click="store" class="btn btn-success">Store Entry</button>

        </div>
        <div class="panel-footer">
            <editor-status-bar
                v-bind:entry="entry"
            ></editor-status-bar>
        </div>
    </div>
</template>

<script>

    import EditorStatusBar from './EditorStatusBar.vue';
    import marked from 'marked';
    import autosize from 'autosize';
    import localStorage from 'vue-localstorage';
    import axios from 'axios';

    export default {

        components: {
            'editorStatusBar': EditorStatusBar
        },

        props: ['entry'],

        mounted() {
            autosize(document.querySelector('textarea'));
        },

        data: () => {
            return {}
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

            store () {
                let token = this.$localStorage.get('jwt-token');
                axios.patch(`/api/journals/${this.entry.journal_id}/entries/${this.entry.id}`, { content: this.entry.content}, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then((response) => {
                    console.log(response);
                    alert("Entry updated");
                })
                .catch((response) => {
                    console.error("An error accoured", response);
                });

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

