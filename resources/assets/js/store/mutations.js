import * as types from './mutation-types.js';

import router from './../router/index.js';

export default {
    [types.GET_JWT_TOKEN] (state, payload) {
        state.jwt.token = payload.token;
        state.jwt.expiresAt = payload.expires_at * 1000;
    },
    [types.RECEIVE_JOURNALS] (state, payload) {
        state.journals = payload;
    },
    [types.ERROR_JOURNALS] (state, payload) {
        alert(payload);
    },

    [types.RECEIVE_ENTRIES] (state, payload) {
        state.entries = payload;
    },
    [types.SELECT_ENTRY] (state, payload) {
        state.entry = payload;
    },

    [types.MASTERPASSWORD_CREATED] (state, payload) {
        console.log(types.MASTERPASSWORD_CREATED);
    },

    /**
     * Unlock Diary App
     * Encryption Password is Stored
     * User gets redirected to intendet url
     */
    [types.UNLOCKED] (state, payload) {
        state.isUnlocked = true;
        state.encryption_password = payload.encryption_password;

        router.push(payload.redirect);
    },

    [types.LOCKED] (state) {
        state.isUnlocked = false;
        state.encryption_password = null;
        state.journals = null;
        state.entries = null;
    },

    [types.GET_USER] (state, payload) {
        state.user = payload;
        state.hasMasterPassword = payload.has_master_password;
    },

    [types.ADD_JOURNAL] (state, payload) {
        // state.active_entry = payload;
    },
    [types.UPDATE_ENTRY] (state, payload) {
        // state.entry = payload;
        // alert("Entry saved.");
    },
    [types.DELETE_ENTRY] (state, payload) {
        router.back();
    },
    [types.ADD_ENTRY] (state, payload) {
        // state.active_entry = payload;
    }
}