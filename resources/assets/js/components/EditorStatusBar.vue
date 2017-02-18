<template>
    <div class="o-editor-status-bar row">
        <div class="col-sm-6">
            Words: {{ wordCount }}
        </div>
        <div class="col-sm-6 text-right">
            Last Updated {{ lastUpdated }}
        </div>
    </div>
</template>

<script>
    import count from 'word-count';
    import moment from 'moment';

    export default {
        props: ['entry'],

        computed: {
            wordCount() {
                return count(this.entry.content);
            },

            lastUpdated() {
                return moment(this.entry.updated_at).fromNow();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .o-editor-status-bar {
        // background: orange;
    }
</style>
