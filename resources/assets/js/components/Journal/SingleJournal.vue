<template>
    <router-link :to="{ name: 'journals.show', params: { journalId: journal.id }}" class="list-group-item justify-content-between" tag="div">
        {{ decryptedTitle }}
        <small>{{ updatedAt }}</small>
    </router-link>
</template>

<script>
import moment from 'moment';
import Crypto from './../../classes/Crypto.js';

export default {
    props: ['journal'],

    computed: {
        createdAt () {
            return moment(this.journal.attributes.created_at).fromNow();
        },

        updatedAt () {
            return moment(this.journal.attributes.updated_at).fromNow();
        },

        decryptedTitle () {
            let crypto = new Crypto(this.$store.state.encryption_password);
            return crypto.decrypt(
                this.journal.attributes.title
            );
        }
    }
}
</script>

<style scoped>
    .list-group-item:hover {
        cursor: pointer;
        background-color: #f1f1f1;
    }
</style>

