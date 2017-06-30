<template>
    <div>
        <create-journal></create-journal>
        <journal-drawer></journal-drawer>
    </div>
</template>

<script>
import CreateJournal from './../components/Journal/CreateJournal.vue';
import JournalDrawer from './../components/Journal/JournalDrawer.vue';

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