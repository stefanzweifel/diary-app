<template>
    <div v-if="user">
        <unlock-screen v-if="has_master_password"></unlock-screen>
        <create-master-password v-if="! has_master_password"></create-master-password>
    </div>
</template>

<script>
    import UnlockScreen from './UnlockScreen.vue';
    import CreateMasterPassword from './CreateMasterPassword.vue';

    export default {

        components: {
            'unlock-screen': UnlockScreen,
            'create-master-password': CreateMasterPassword
        },

        computed: {
            user () {
                return this.$store.state.user;
            },

            has_master_password () {
                return this.$store.state.has_master_password;
            },
        }
    }
</script>