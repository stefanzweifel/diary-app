<template>
    <div class="card">
        <div class="card-block">
            <h4 class="card-title">{{ decryptedTitle }}</h4>
            <p class="card-text">
                <small class="text-muted">
                    Last updated {{ formatedDate }}
                </small>
            </p>
            <router-link :to="{ name: 'entries.preview', params: { entryId: entry.id }}" class="card-link">
                Read
            </router-link>
        </div>
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
                this.entry.attributes.title
            );
        }
    }
}
</script>

<style lang="scss" scoped>
    .list-group-item:hover {
        cursor: pointer;
    }
</style>