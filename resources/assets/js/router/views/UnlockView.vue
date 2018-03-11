<template>
    <div class="h-screen flex items-center content-center justify-center">
        <master-password v-if="!is_unlocked"></master-password>
    </div>
</template>

<script>
import MasterPassword from './../../components/Util/MasterPassword.vue';

export default {

    components: {
        MasterPassword
    },

    created() {
        this.$store.dispatch('getUser');
    },

    computed: {
        is_unlocked () {
            return this.$store.state.is_unlocked;
        }
    }
}

</script>
