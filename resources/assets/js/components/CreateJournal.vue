<template>
    <div>

        <div class="form-group">
            <label for="journal-title">Journal Name</label>
            <input type="text" id="journal-title" class="form-control" v-model="title" placeholder="Name of your Journal">
        </div>

        <button v-on:click="store" class="btn btn-success">
            Create Journal
        </button>

        <hr>

    </div>
</template>

<script>
    import JournalClient from './../classes/api/Journal';
    import localStorage from 'vue-localstorage';
    import axios from 'axios';

    export default {

        mounted() {

        },

        data: () => {
            return {
                title: '',
            }
        },

        methods: {
            store () {
                let token = this.$localStorage.get('jwt-token');
                axios.post('/api/journals', { title: this.title}, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then((response) => {
                    console.log(response);
                    alert("Journal Created. Sync Data Now.");
                })
                .catch((response) => {
                    console.error("An error accoured", response);
                });
            }
        }
    }
</script>

