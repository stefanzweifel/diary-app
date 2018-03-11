<template>
    <router-link
        :to="{ name: 'entries.show', params: { entryId: entry.id }}"
        class="p-4 text-black border-b bg-white cursor-pointer hover:bg-grey-lighter"
        tag="div"
    >
        <h4 class="mb-2">{{ decryptedTitle }}</h4>
        <small class="block">{{ createdAt }}</small>
        <small class="block text-grey-darker">updated {{ updatedAt }}</small>
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
