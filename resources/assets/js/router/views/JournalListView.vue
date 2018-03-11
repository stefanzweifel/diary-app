<template>
    <div class="flex">
        <div class="h-screen bg-white flex flex-col w-1/3 border-r">
            <!-- This Top Bar should be always visible -->
            <div class="p-4 border-b shadow z-10">
                <create-journal></create-journal>
            </div>

            <div class="bg-grey-lightest flex-grow overflow-scroll">
                <div v-if="journals && journals.length == 0">
                    <div class="text-black text-center p-4 rounded mt-2">
                        <p class="mb-2 text-grey-dark">No Journals available 😢</p>
                    </div>
                </div>
                <single-journal
                    v-if="journals.length > 0"
                    v-for="journal in journals"
                    :key="journal.id"
                    :journal="journal">
                </single-journal>
            </div>
        </div>
        <div class="w-full" v-if="journals && journals.length > 0">
            <router-view></router-view>
        </div>
        <div v-else class="flex justify-center items-center w-full">
            <p class="text-grey text-3xl italic">Your entries will be shown here</p>
        </div>
    </div>
</template>

<script>
import CreateJournal from './../../components/Journal/CreateJournal.vue';
import SingleJournal from './../../components/Journal/SingleJournal.vue';
import router from 'vue-router';

export default {

    components: {
        CreateJournal,
        SingleJournal
    },

    computed: {
        journals () {
            return this.$store.state.journals
        }
    },

    created() {

    console.log(this.$router);

        this.$store.dispatch('getUser');
    },
}

</script>
