<template>

    <div class="row">
        <div class="col-md-3 journal-list">
            <create-journal></create-journal>
            <div class="list-group">
                <journal
                    v-if="journals.length > 0"
                    v-for="journal in journals"
                    :key="journal.id"
                    :journal="journal">
                </journal>
            </div>
        </div>
        <div class="col-md-9" v-if="journals && journals.length > 0">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import CreateJournal from './../../components/Journal/CreateJournal.vue';
import Journal from './../../components/Journal/SingleJournal.vue';

export default {

    components: {
        CreateJournal,
        Journal
    },

    computed: {
        journals () {
            return this.$store.state.journals
        }
    },

    created() {
        this.$store.dispatch('getUser');
    },
}

</script>

<style scoped>
    .journal-list {
        border-right: solid 1px black;
        overflow: scroll;
    }
</style>