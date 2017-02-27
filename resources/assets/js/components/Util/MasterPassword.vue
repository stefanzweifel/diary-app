<template>
    <div v-if="user">
        <div class="alert alert-warning" v-if="! has_master_password">
            You haven't setup a Master Password yet. Creat Master Password now!
        </div>
        <div class="alert alert-info" v-if="has_master_password">
            Welcome back! Enter your Master Password to access your Journal.
        </div>

        <div class="form-group">
            <label>Master Password</label>
            <input type="password" class="form-control" v-model="password" placeholder="Password">
        </div>

        <div class="form-group" v-if="! has_master_password">
            <label>Confirm your password</label>
            <input type="password" class="form-control" v-model="password_confirmation" placeholder="Password Confirmation">
        </div>

        <!-- If User already has a Master Password defined, show him the "Unlock" Screen -->
        <button @click="unlock" v-if="has_master_password" class="btn btn-primary">Unlock</button>

        <!-- If User doens't have a mater password, show him the Setup Screeen -->
        <button @click="create" v-if="! has_master_password" v-bind:disabled="!password_match" class="btn btn-success">Create Master Password</button>
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
            encryption_password () {
                return this.$store.state.encryption_password;
            },

            user () {
                return this.$store.state.user;
            },

            has_master_password () {
                return this.$store.state.has_master_password;
            },

            password_match () {
                return this.password == this.password_confirmation;
            }
        },

        methods: {

            unlock () {
                // Send Password to API
                // API compares against stored MasterPassword in Database
                // API returns encrypted Hash
                // This Hash is used as the local AES Password Part
                this.$store.dispatch('unlock', {
                    password: this.password
                });
            },

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