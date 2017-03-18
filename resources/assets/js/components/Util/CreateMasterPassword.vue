<template>
    <div>
        <div class="alert alert-warning">
            You haven't setup a Master Password yet. Creat Master Password now!
        </div>

        <form v-on:submit.prevent="create">
            <div class="form-group">
                <label>Master Password</label>
                <input type="password" class="form-control" v-model="password" placeholder="Password">
            </div>

            <div class="form-group">
                <label>Confirm your password</label>
                <input type="password" class="form-control" v-model="password_confirmation" placeholder="Password Confirmation">
            </div>

            <button @click="create" v-bind:disabled="!password_match" class="btn btn-success">Create Master Password</button>
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