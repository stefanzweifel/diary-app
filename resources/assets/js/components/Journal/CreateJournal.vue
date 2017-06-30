<template>
    <form @submit.prevent="store"style="margin-bottom: 1em;">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" v-model="title" placeholder="Name of your Journal">
                <span class="input-group-btn">
                   <button type="submit" class="btn btn-success" v-bind:disabled="!title">
                        Create Journal
                    </button>
                </span>
            </div>
        </div>
    </form>
</template>

<script>
import Crypto from './../../classes/Crypto.js';

export default {

    data: () => {
        return {
            title: '',
        }
    },

    methods: {
        store () {
            let crypto = new Crypto(this.$store.state.encryption_password);

            this.$store.dispatch('createNewJournal', crypto.encrypt(
                this.title
            ));

            this.title = '';
        }
    }
}
</script>

