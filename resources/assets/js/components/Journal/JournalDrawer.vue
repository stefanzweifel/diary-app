<template>

</div>

</template>

<script>

export default {

    components: {
        Journal
    },

    computed: {
        journals () {
            return this.$store.state.journals
        }
    }
}
</script>