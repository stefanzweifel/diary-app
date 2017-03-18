<template>
    <div class="list-group-item">
        <p class="list-group-item-text">
            <h4>{{ decryptedTitle }}</h4>
            <i>{{ formatedDate }}</i>
        </p>

        <router-link :to="{ name: 'entries.preview', params: { entryId: entry.id }}" class="btn btn-success">Preview</router-link>
        <router-link :to="{ name: 'entries.edit', params: { entryId: entry.id }}" class="btn btn-default">Edit</router-link>
    </div>
</template>

<script>
import Crypto from './../classes/Crypto.js';
import moment from 'moment';

export default {
    props: ['entry'],

    computed: {
        formatedDate () {
            return moment(this.entry.created_at).format('DD.MM.YYYY, h:mm');
        },

        decryptedTitle () {
            let crypto = new Crypto(this.$store.state.encryption_password);

            return crypto.decrypt(
                this.entry.title
            );
        }
    }
}
</script>