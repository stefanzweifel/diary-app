<template>
    <div>
        <div class="container-fluid">
            <div class="row" v-if="! is_unlocked">
                <div class="col-md-4 col-md-offset-4">
                    <master-password></master-password>
                </div>
            </div>

            <div class="demo container">
                <p>
                    <router-link to="/foo">Go to Foo</router-link>
                    <router-link to="/bar">Go to Bar</router-link>
                    <router-link to="/user/fooBAR">USER FOO BAR</router-link>
                </p>
                <transition>
                    <router-view></router-view>
                </transition>
            </div>

            <div class="row" v-if="is_unlocked">
                <breadcrumb></breadcrumb>
                <div class="col-sm-3">
                    <create-journal></create-journal>
                    <journal-drawer></journal-drawer>
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
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <lock></lock>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

</template>

<script>
    import EntryDrawer from './EntryDrawer.vue';
    import CreateJournal from './CreateJournal.vue';
    import MasterPassword from './Util/MasterPassword.vue';
    import JournalDrawer from './JournalDrawer.vue';
    import Lock from './Util/Lock.vue';
    import * as types from './../store/mutation-types.js';

    import Breadcrumb from './Util/Breadcrumb.vue';

    export default {
        components: {
            'entryDrawer': EntryDrawer,
            'journalDrawer': JournalDrawer,
            'create-journal': CreateJournal,
            'master-password': MasterPassword,
            'lock': Lock,
            'breadcrumb': Breadcrumb
        },

        computed: {
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

