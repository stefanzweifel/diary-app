<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="btn-group">
                    <button v-on:click="sync" class="btn btn-primary btn-small">Sync</button>
                    <button v-on:click="refreshToken" class="btn btn-warning btn-small">Refresh Token</button>
                </div>

                <hr>

                <create-journal></create-journal>

                <!-- <journal-drawer></journal-drawer> -->
                <div class="list-group">
                    <journal
                        v-for="journal in journals"
                        v-bind:journal="journal"
                        v-on:selectJournal="selectJournal">
                    </journal>
                </div>
            </div>
            <div class="col-sm-9">
                <entry-drawer
                    v-if="selectedJournal"
                    v-bind:journal="selectedJournal"
                    v-bind:sync="EntryCreated"
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
    // import JournalDrawer from './JournalDrawer.vue';
    import Journal from './Journal.vue';
    import CreateJournal from './CreateJournal.vue';
    import localStorage from 'vue-localstorage'

    export default {
        components: {
            'editor': Editor,
            'entryDrawer': EntryDrawer,
            // 'journalDrawer': JournalDrawer,
            'journal': Journal,
            'create-journal': CreateJournal
        },
        data: () => {
            return {
                journals: null,
                selectedJournal: null,
                EntryCreated: null
            }
        },

        mounted() {

            let journals = this.$localStorage.get('journals');
            if (journals == null) {
                axios.get('/token')
                    .then((response) => {
                        window.JwtToken = response.data.token;
                        this.$localStorage.set('jwt-token', response.data.token);
                        this.getJournals();
                    })
            }
            else {
                this.journals = JSON.parse(journals);
            }
        },

        methods: {

            sync () {
                this.getJournals();
            },

            refreshToken() {
                axios.get('token')
                .then((response) => {
                    this.$localStorage.set('jwt-token', JSON.stringify(response.data.token));
                })
            },

            selectJournal (journal) {
                this.selectedJournal = journal;
            },

            getJournals () {

                let token = this.$localStorage.get('jwt-token');

                axios.get('/api/journals', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then((response) => {
                    this.$localStorage.set('journals', JSON.stringify(response.data.journals));
                    this.journals = response.data.journals;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }

    }
</script>

<style scoped>

</style>

