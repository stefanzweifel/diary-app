<template>
    <router-link :to="{ name: 'journals.show', params: { journalId: journal.id }}" class="border-b overflow-hidden bg-white hover:bg-grey-lighter cursor-pointer" tag="div">
        <div class=" p-4">
            <h4 class="font-bold text-lg mb-2">{{ decryptedTitle }}</h4>
            <span class="inline-block text-sm font-normal text-grey-darker mr-2">Updated {{ updatedAt }}</span>
        </div>
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

