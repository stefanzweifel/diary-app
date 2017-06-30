<template>
    <div class="card">
        <div class="card-block">
            <h4 class="card-title">{{ decryptedTitle }}</h4>
            <p class="card-text">
                {{ decryptedContent }}
            </p>
            <p class="card-text">
                <small class="text-muted">
                    Last updated {{ formatedDate }}
                </small>
            </p>
            <show-entry-button :entry="entry"></show-entry-button>
        </div>
    </div>
</template>

<script>
import Crypto from './../../classes/Crypto.js';
import moment from 'moment';
import ShowEntryButton from './ShowEntryButton.vue';

export default {
    props: ['entry'],

    components: {
        ShowEntryButton
    },

    computed: {
        formatedDate () {
            return moment(this.entry.created_at).format('DD.MM.YYYY, hh:mm');
        },

        decryptedTitle () {
            let crypto = new Crypto(this.$store.state.encryption_password);

            return crypto.decrypt(
                this.entry.attributes.title
            );
        },

        decryptedContent () {
            let crypto = new Crypto(this.$store.state.encryption_password);

            return crypto.decrypt(
                this.entry.attributes.content
            );
        }
    }
}
</script>