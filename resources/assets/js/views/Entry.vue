<template>
    <div class="panel panel-default">
        <div class="panel-heading">{{ title }}</div>
        <div class="panel-body">
            <vue-markdown :source="content"></vue-markdown>
        </div>
    </div>
</template>

<script>

import Crypto from './../classes/Crypto.js';
import VueMarkdown from 'vue-markdown';

export default {
    components: {
        VueMarkdown
    },

    data () {
        return {
            title: '',
            content: ''
        }
    },

    created() {

        // Get Entry By ParamId

        this.$store.dispatch('getEntry', this.$route.params.entryId);
    },

    mounted() {

        // We have to wait, till we have the single entry in the state

        // // Decrypt Title and Content and store the encrypted Values inMemory
        // let crypto = new Crypto(this.$store.state.encryption_password);
        // let title =  crypto.decrypt(
        //     this.entry.title
        // );

        // this.title = title;

        // let crypto2 = new Crypto(this.$store.state.encryption_password);
        // let content =  crypto2.decrypt(
        //     this.entry.content
        // );

        // this.content = content;

    },

    computed: {
        entry () {
            return this.$store.state.active_entry;
        }
    }
}
</script>