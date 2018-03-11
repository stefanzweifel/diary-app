<template>
    <div class="text-center">
        <div class="text-center py-4 lg:px-4 mb-2">
            <div class="py-2 px-4 bg-indigo-darker items-center text-indigo-lightest leading-none rounded-full flex lg:inline-flex" role="alert">
                <span class="font-semibold mr-2 text-left flex-auto">Welcome back! Enter your Master Password to access your Journal.</span>
            </div>
        </div>
        <form @submit.prevent="unlock">
            <input type="password" class="shadow appearance-none inline-block border rounded py-2 px-3 text-grey-darker" v-model="password" placeholder="Enter Master Password">
            <button type="submit" class="bg-green hover:bg-green-dark inline-block text-white no-underline font-bold py-2 px-4 rounded">
                <i class="fa fa-unlock-alt"></i> Unlock
            </button>
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
