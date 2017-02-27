<template>
    <div class="container-fluid">
        <div class="row" v-if="! is_unlocked">
            <div class="col-md-6 col-md-offset-3">
                <master-password></master-password>
            </div>
        </div>
        <div class="row" v-if="is_unlocked">
            <div class="col-sm-3">
                <create-journal></create-journal>

                <div class="list-group">
                    <journal
                        v-for="journal in journals"
                        :journal="journal">
                    </journal>
                </div>
            </div>
            <div class="col-sm-9">
                <entry-drawer
                    v-if="selectedJournal"
                    :journal="selectedJournal"
                ></entry-drawer>

                <div v-if="!selectedJournal">
                    <div class="text-center panel panel-warning">
                        <div class="panel-heading">Select a Journal First</div>
                        <div class="panel-body">
                            Select a Journal first!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Editor from './Editor.vue';
    import EntryDrawer from './EntryDrawer.vue';
    import Journal from './Journal.vue';
    import CreateJournal from './CreateJournal.vue';
    import MasterPassword from './Util/MasterPassword.vue';


    export default {
        components: {
            'editor': Editor,
            'entryDrawer': EntryDrawer,
            'journal': Journal,
            'create-journal': CreateJournal,
            'master-password': MasterPassword
        },

        computed: {
            journals () {
                return this.$store.state.journals
            },
            selectedJournal () {
                return this.$store.state.active_journal;
            },
            jsxToken () {
                return this.$store.state.jsx_token
            },
            encryption_password () {
                return this.$store.state.encryption_password
            },
            is_unlocked () {
                return this.$store.state.is_unlocked;
            }
        },

        mounted() {
            // Get JwtToken
            this.$store.dispatch('jwtToken');
        }
    }
</script>

<style scoped>

</style>

