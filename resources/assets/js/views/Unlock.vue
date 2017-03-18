<template>
    <div>
        <master-password v-if="!is_unlocked"></master-password>
    </div>
</template>

<script>
import MasterPassword from './../components/Util/MasterPassword.vue';

export default {

    components: {
        MasterPassword
    },

    created() {
        this.$store.dispatch('jwtToken');
    },

    computed: {
        is_unlocked () {
            return this.$store.state.is_unlocked;
        }
    }
}

</script>