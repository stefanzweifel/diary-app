<template>
    <div v-if="userHasBeenLoaded">
        <unlock-screen v-if="masterPasswordHasBeenSet"></unlock-screen>
        <create-master-password v-if="! masterPasswordHasBeenSet"></create-master-password>
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
        userHasBeenLoaded () {
            return this.$store.state.user;
        },

        masterPasswordHasBeenSet () {
            return this.$store.state.hasMasterPassword;
        },
    }
}
</script>