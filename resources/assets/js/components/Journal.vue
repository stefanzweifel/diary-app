<template>
    <div class="o-journal-element list-group-item" @click="selectJournal" v-bind:class="{ active: isActive }">
        <h4 class="list-group-item-heading">{{ decryptedTitle }}</h4>
        <p class="list-group-item-text">
            Created {{ createdAt }}
        </p>
    </div>
</template>

<script>
    import * as types from '../store/mutation-types.js';
    import moment from 'moment';
    import Crypto from './../classes/Crypto.js';

    export default {
        props: ['journal'],

        methods: {
            selectJournal () {
                this.$store.commit(types.SELECT_JOURNAL, this.journal);
                this.$store.dispatch('getEntries');
            }
        },

        computed: {
            isActive () {
                if (this.active_journal) {
                    return this.journal.id == this.$store.state.active_journal.id;
                }
                return false;
            },

            createdAt () {
                return moment(this.journal.created_at).fromNow();
            },

            /**
             * Encrypt Journal Title with User Encryption Key
             * @return {string}
             */
            decryptedTitle () {
                let crypto = new Crypto(this.$store.state.encryption_password);
                return crypto.decrypt(
                    this.journal.title
                );

                return decryptedTitle;
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

