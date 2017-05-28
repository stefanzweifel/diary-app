<template>
    <router-link :to="{ name: 'journals.show', params: { journalId: journal.id }}" tag="div" class="list-group-item">
        <h4 class="list-group-item-heading">{{ decryptedTitle }}</h4>
        <p class="list-group-item-text">
            <small>created {{ createdAt }}</small>
        </p>
    </router-link>
</template>

<script>
import moment from 'moment';
import Crypto from './../classes/Crypto.js';

export default {
    props: ['journal'],

    computed: {
        createdAt () {
            return moment(this.journal.created_at).fromNow();
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

