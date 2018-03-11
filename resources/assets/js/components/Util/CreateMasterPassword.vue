<template>
    <div>
        <div class="bg-blue-lightest border border-blue-light text-blue-dark px-4 py-3 rounded relative mb-4" role="alert">
            You haven't setup a master password yet. Creat master password now!
        </div>

        <form v-on:submit.prevent="create">

            <div class="mb-4">
                <label for="password" class="block text-grey-darker text-sm font-bold mb-2">Master Password</label>
                <input id="password" type="password" class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker w-full" v-model="password" placeholder="Password">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-grey-darker text-sm font-bold mb-2">Confirm your password</label>
                <input id="password_confirmation" type="password" class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker w-full" v-model="password_confirmation" placeholder="Password Confirmation">
            </div>

            <button @click="create" type="submit" v-bind:disabled="!password_match" class="bg-green hover:bg-green-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer">Create Master Password</button>
        </form>
    </div>
</template>

<script>
export default {

    data: () => {
        return {
            password: '',
            password_confirmation: ''
        }
    },

    computed: {
        password_match () {
            return this.password == this.password_confirmation;
        }
    },

    methods: {
        create () {
            // Send Password and Password Confirmation to API
            // API Validates Data (throws error)
            // API creates bycrypt hash and stores it as MasterPassword
            // API returns sucess.
            // => User then has to unlock his diary and enter his password again.
            this.$store.dispatch('createMasterPassword', {
                password: this.password,
                password_confirmation: this.password_confirmation
            });
        }
    }
}
</script>
