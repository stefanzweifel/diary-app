<template>
    <div class="card-columns">
        <journal
            v-if="journals.length > 0"
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
        Journal
    },

    computed: {
        journals () {
            return this.$store.state.journals
        }
    }
}
</script>