<template>
    <div class="card">
        <div class="card-block">
            <h4 class="card-title">{{ decryptedTitle }}</h4>
            <p class="card-text">
                <small class="text-muted">
                    Last updated {{ createdAt }}
                </small>
            </p>
            <router-link :to="{ name: 'journals.show', params: { journalId: journal.id }}" class="btn btn-primary">Read</router-link>
            <delete-journal :journal="journal"></delete-journal>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Crypto from './../../classes/Crypto.js';
import DeleteJournal from './DeleteJournal.vue';

export default {
    props: ['journal'],

    components: {
        DeleteJournal
    },

    computed: {
        createdAt () {
            return moment(this.journal.attributes.created_at).fromNow();
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

