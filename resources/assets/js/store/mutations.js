import * as types from './mutation-types.js';

export default {
    [types.GET_JWT_TOKEN] (state, payload) {
        state.jwt_token = payload;
    },
    [types.RECEIVE_JOURNALS] (state, payload) {
        state.journals = payload;
    },
    [types.ERROR_JOURNALS] (state, payload) {
        alert(payload);
    },
    [types.SELECT_JOURNAL] (state, payload) {
        state.active_journal = payload;
        state.active_entry = null;
    },
    [types.RECEIVE_ENTRIES] (state, payload) {
        state.entries = payload;
    },
    [types.SELECT_ENTRY] (state, payload) {
        state.active_entry = payload;
    },

    [types.MASTERPASSWORD_CREATED] (state, payload) {
        console.log(types.MASTERPASSWORD_CREATED);
    },

    [types.UNLOCKED] (state, encryption_password) {
        state.is_unlocked = true;
        state.encryption_password = encryption_password;
    },

    [types.LOCKED] (state) {
        state.is_unlocked = false;
        state.encryption_password = null;
        state.active_journal = null;
        state.journals = null;
        state.active_entry = null;
        state.entries = null;
    },

    [types.GET_USER] (state, payload) {
        state.user = payload;
        state.has_master_password = payload.has_master_password;
    },

    [types.ADD_JOURNAL] (state, payload) {
        // state.active_entry = payload;
    },
    [types.UPDATE_ENTRY] (state, payload) {
        // state.active_entry = payload;
        // alert("Entry saved.");
    },
    [types.DELETE_ENTRY] (state, payload) {
        state.active_entry = null;
    },
    [types.ADD_ENTRY] (state, payload) {
        // state.active_entry = payload;
    }
}