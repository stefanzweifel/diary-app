<template>
    <div>
        <create-journal></create-journal>
        <journal-drawer></journal-drawer>
    </div>
</template>

<script>
import CreateJournal from './../components/CreateJournal.vue';
import JournalDrawer from './../components/JournalDrawer.vue';

export default {

    components: {
        CreateJournal,
        JournalDrawer
    },

    created() {
        this.$store.dispatch('getUser');
    },
}

</script>