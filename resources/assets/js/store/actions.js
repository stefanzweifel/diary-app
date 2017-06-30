import * as types from './mutation-types.js';
import User from './../models/User.js';
import MasterPassword from './../models/MasterPassword.js';
import Journal from './../models/Journal.js';
import Entry from './../models/Entry.js';

export default {

    getUser ({ commit }) {
        new User()
            .me()
            .then((response) => {
                commit(types.GET_USER, response.data.user);
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    // ----------------------------------------------------------

    createMasterPassword ({ commit, dispatch }, payload) {
        new MasterPassword()
            .create(payload.password, payload.password_confirmation)
            .then((response) => {
                commit(types.MASTERPASSWORD_CREATED);
                dispatch('getUser');
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    unlock ({ commit, dispatch }, payload) {
        new MasterPassword()
            .verify(payload.password)
            .then((response) => {
                commit(types.UNLOCKED, {
                    encryption_password: response.data.encryption_key,
                    redirect: payload.redirect
                });
                dispatch('getJournals');
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    // ----------------------------------------------------------

    getEntry({ commit }, entryId) {
        new Entry()
            .find(entryId)
            .then((response) => {
                commit(types.SELECT_ENTRY, response.data.data);
            })
            .catch(function (error) {
                commit(types.ERROR_ENTRIES, error);
            });
    },

    getEntries ({ commit }, journalId) {
        new Entry()
            .all(journalId)
            .then((response) => {
                commit(types.RECEIVE_ENTRIES, response.data.data);
            })
            .catch(function (error) {
                commit(types.ERROR_ENTRIES, error);
            });
    },

    createNewEntry ({ commit, dispatch }, journalId) {
        new Entry()
            .create(journalId)
            .then((response) => {
                commit(types.ADD_ENTRY);
                dispatch('getEntries', journalId);
            })
            .catch(function (error) {
                console.log(error);
                // commit(types.ERROR_ENTRIES, error);
            });
    },

    updateEntry({ commit, dispatch }, payload) {
        new Entry()
            .update(payload.entry, {
                title: payload.title,
                content: payload.content
            })
            .then((response) => {
                commit(types.UPDATE_ENTRY);
                dispatch('getEntry', payload.entry);
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    deleteEntry({ commit, dispatch }, entryId) {

        new Entry()
            .destroy(entryId)
            .then((response) => {
                commit(types.DELETE_ENTRY);
                // dispatch('getEntries');
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    // ----------------------------------------------------------

    // Load Journals
    getJournals ({ commit }) {
        new Journal()
            .all()
            .then((response) => {
                commit(types.RECEIVE_JOURNALS, response.data.data);
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    createNewJournal({ commit, dispatch }, title) {
        new Journal()
            .create(title)
            .then((response) => {
                commit(types.ADD_JOURNAL);
                // Sync Journals
                dispatch('getJournals');
            })
            .catch(function (error) {
                console.log(error);
                // commit(types.ERROR_ENTRIES, error);
            });
    },

    deleteJournal({ commit, dispatch }, journalId) {
        new Journal()
            .destroy(journalId)
            .then((response) => {
                commit(types.DELETE_JOURNAL);
                // Sync Journals
                dispatch('getJournals');
            })
            .catch(function (error) {
                console.log(error);
                // commit(types.ERROR_ENTRIES, error);
            });
    }
};