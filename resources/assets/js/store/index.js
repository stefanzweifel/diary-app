import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import state from './state.js';
import getters from './getters.js';
import mutations from './mutations.js';
import actions from './actions.js';

const options = {
    state,
    getters,
    mutations,
    actions
};

export default new Vuex.Store(options);
export { options }