<template>
    <router-link :to="{ name: 'entries.show', params: { entryId: entry.id }}" class="list-group-item list-group-item-action flex-column align-items-start" tag="div">
        {{ decryptedTitle }}
        <small>{{ createdAt }}</small>
        <small>updated {{ updatedAt }}</small>
    </router-link>
</template>

<script>
import Crypto from './../../classes/Crypto.js';
import moment from 'moment';

export default {
    props: ['entry'],

    computed: {
        createdAt () {
            return moment(this.entry.attributes.created_at).format('DD.MM.YYYY, HH:mm');
        },
        updatedAt () {
            return moment(this.entry.attributes.updated_at).fromNow();
        },

        decryptedTitle () {
            let crypto = new Crypto(this.$store.state.encryption_password);

            return crypto.decrypt(
                this.entry.attributes.title
            );
        }
    }
}
</script>