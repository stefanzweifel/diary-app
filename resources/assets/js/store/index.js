import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import actions from './actions.js';
import mutations from './mutations.js';
import Crypto from './../classes/Crypto.js';

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

        // Entries for the current journal
        entries: null,

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
        },
        hasTokenExpired: state => {
            let d = new Date();
            return d.getTime() > state.jwt.expiresAt;
        }
    },
    mutations,
    actions
})