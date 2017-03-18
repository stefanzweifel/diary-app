<template>
    <div class="panel panel-default" v-if="entry">
        <div class="panel-heading">{{ title }}</div>
        <div class="panel-body">
            <vue-markdown :source="content"></vue-markdown>
        </div>
        <div class="panel-footer">
            <router-link :to="{ name: 'entries.edit', params: { entryId: entry.id }}" class="btn btn-default">Edit</router-link>
        </div>
    </div>
    <div v-else>
        <h1>Loading</h1>
    </div>
</template>

<script>

import Crypto from './../classes/Crypto.js';
import VueMarkdown from 'vue-markdown';

export default {
    components: {
        VueMarkdown
    },

    created() {
        this.$store.dispatch('getEntry', this.$route.params.entryId);
    },

    computed: {
        entry() {
            return this.$store.state.entry;
        },

        title() {
            if (this.entry == null) {
                return 'LOADING';
            }

            let crypto = new Crypto(this.$store.state.encryption_password);
            return crypto.decrypt(this.entry.title);
        },

        content() {
            if (this.entry == null) {
                return 'LOADING';
            }
            let crypto2 = new Crypto(this.$store.state.encryption_password);
            return crypto2.decrypt(this.entry.content);
        }
    }
}
</script>