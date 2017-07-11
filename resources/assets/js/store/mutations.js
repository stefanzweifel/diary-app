import * as types from './mutation-types.js';

import router from './../router/index.js';
import Crypto from './../classes/Crypto.js';

export default {
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

        state.decryptedTitle = new Crypto(state.encryption_password).decrypt(payload.attributes.title);
        state.decryptedContent = new Crypto(state.encryption_password).decrypt(payload.attributes.content);
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

        if (payload.redirect === undefined) {
            return router.push('/');
        }

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
        // router.back();
    },
    [types.DELETE_JOURNAL] (state, payload) {
        router.push({ name: 'journals.index'})
    },
    [types.ADD_ENTRY] (state, payload) {
        // Append new Entry to Global Entries List
        state.entries.unshift(payload.data.data);

        // Switch to Entry Details View
        router.push({
            name: 'entries.editor',
            params: {
                entryId: payload.data.data.id
            }
        });
    }

}