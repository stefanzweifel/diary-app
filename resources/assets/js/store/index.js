import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import actions from './actions.js';
import mutations from './mutations.js';

export default new Vuex.Store({
    state: {
        is_unlocked: false,
        encryption_password: null,
        jwt_token: null,
        journals: null,
        active_journal: null,
        entries: null,
        active_entry: null,
        user: null,
        has_master_password: false
    },
    getters: {

    },
    mutations,
    actions
})