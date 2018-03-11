<template>
    <form @submit.prevent="store">
        <input type="text" class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker" v-model="title" placeholder="Name of your Journal">
        <button type="submit" class="bg-green hover:bg-green-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer" v-bind:disabled="!title">
            Create Journal
        </button>
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

