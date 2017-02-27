<template>
    <div style="margin-bottom: 1em;">
        <div class="form-group">
            <label for="journal-title">Journal Name</label>
            <input type="text" id="journal-title" class="form-control" v-model="title" placeholder="Name of your Journal">
        </div>

        <button @click="store" class="btn btn-success">
            Create Journal
        </button>
    </div>
</template>

<script>
    import JournalClient from './../api/Journal';
    import localStorage from 'vue-localstorage';
    import axios from 'axios';

    export default {

        data: () => {
            return {
                title: '',
            }
        },

        methods: {
            store () {
                this.$store.dispatch('createNewJournal', this.title);
            }
        }
    }
</script>

