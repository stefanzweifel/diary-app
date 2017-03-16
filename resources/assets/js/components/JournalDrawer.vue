<template>
    <div class="o-journal-drawer">
        <div class="list-group">
            <journal
                v-for="journal in journals"
                :journal="journal">
            </journal>
        </div>
    </div>
</template>

<script>
    import Journal from './Journal.vue';

    export default {

        components: {
            'journal': Journal
        },

        computed: {
            journals () {
                return this.$store.state.journals
            }
        }
    }
</script>

<style lang="scss" scoped>
    .o-journal-drawer {
    }
</style>
