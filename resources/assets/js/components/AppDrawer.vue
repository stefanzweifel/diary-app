<template>
    <div>

        <div class="container-fluid">
            <div class="row" v-if="! is_unlocked">
                <div class="col-md-4 col-md-offset-4">
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
                    <div v-if="!selectedJournal">
                        <div class="text-center panel panel-warning">
                            <div class="panel-heading">Select a Journal First</div>
                            <div class="panel-body">
                                Select a Journal first!
                            </div>
                        </div>
                    </div>
                    <entry-drawer
                        v-if="selectedJournal"
                        :journal="selectedJournal"
                    ></entry-drawer>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-default navbar-fixed-bottom" v-if="is_unlocked">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><button @click="lock" class="btn btn-primary navbar-btn"> <i class="fa fa-lock"></i> Lock Diary</button></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

</template>

<script>
    import Editor from './Editor.vue';
    import EntryDrawer from './EntryDrawer.vue';
    import Journal from './Journal.vue';
    import CreateJournal from './CreateJournal.vue';
    import MasterPassword from './Util/MasterPassword.vue';
    import * as types from './../store/mutation-types.js';


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

        methods: {
            lock () {
                return this.$store.commit(types.LOCKED);
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

