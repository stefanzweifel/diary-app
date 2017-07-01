import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import actions from './actions.js';
import mutations from './mutations.js';

export default new Vuex.Store({
    state: {

        hasMasterPassword: false,
        isUnlocked: false,

        // The Entry the user is currently working with
        entry: null,

        // Encryption Password / Key
        encryption_password: null,

        // All journals
        journals: null,
        selected_journal: null,

        // Entries for the current journal
        entries: null,
        selected_entry: null,

        // The logged in User
        user: null,


        decryptedTitle: '',
        decryptedContent: ''
    },
    getters: {
        isUnlocked: state => {
            return state.isUnlocked;
        },
        isLocked: state => {
            return !state.isUnlocked
        }
    },
    mutations,
    actions
})