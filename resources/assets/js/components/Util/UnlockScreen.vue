<template>
    <div>
        <div class="alert alert-info">
            Welcome back! Enter your Master Password to access your Journal.
        </div>

        <form @submit.prevent="unlock">
            <div class="form-group">
                <div class="input-group">
                    <input type="password" class="form-control input-lg" v-model="password" placeholder="Enter Master Password">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-unlock-alt"></i> Unlock
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {

    data: () => {
        return {
            password: '',
        }
    },

    methods: {
        unlock () {
            // Send Password to API
            // API compares against stored MasterPassword in Database
            // API returns encrypted Hash
            // This Hash is used as the local AES Password Part
            this.$store.dispatch('unlock', {
                password: this.password,
                redirect: this.$route.query.redirect
            });
        }
    }

}
</script>