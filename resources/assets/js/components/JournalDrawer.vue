<template>
    <div class="list-group">
        <journal
            v-if="journals.length > 0"
            v-for="journal in journals"
            :journal="journal">
        </journal>
    </div>
</template>

<script>
import Journal from './Journal.vue';

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