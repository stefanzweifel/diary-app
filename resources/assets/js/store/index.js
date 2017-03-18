import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import actions from './actions.js';
import mutations from './mutations.js';

export default new Vuex.Store({
    state: {

        // Jwt / Auth could be a separate module
        jwt: {
            token: null,
            expiresAt: null
        },
        hasMasterPassword: false,
        isUnlocked: false,


        encryption_password: null,
        journals: null,
        entries: null,
        active_entry: null,
        user: null,
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