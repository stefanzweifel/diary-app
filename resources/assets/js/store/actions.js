import * as types from './mutation-types.js';
import User from './../models/User.js';
import MasterPassword from './../models/MasterPassword.js';
import Journal from './../models/Journal.js';
import Entry from './../models/Entry.js';

export default {

    jwtToken ({ commit, state, dispatch }) {
        new User()
            .jwtToken()
            .then((response) => {
                commit(types.GET_JWT_TOKEN, response.data);

                // When we get the Token, we then start loading the journals
                dispatch('getUser');
            })
    },

    getUser ({ commit, state}) {
        new User(state.jwt.token)
            .me()
            .then((response) => {
                commit(types.GET_USER, response.data.user);
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    // ----------------------------------------------------------

    createMasterPassword ({ commit, state, dispatch }, payload) {
        new MasterPassword(state.jwt.token)
            .create(payload.password, payload.password_confirmation)
            .then((response) => {
                commit(types.MASTERPASSWORD_CREATED);
                dispatch('getUser');
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    unlock ({ commit, state, dispatch }, payload) {
        new MasterPassword(state.jwt.token)
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

    getEntry({ commit, state}, entryId) {
        new Entry(state.jwt.token)
            .find(entryId)
            .then((response) => {
                commit(types.SELECT_ENTRY, response.data.entry);
            })
            .catch(function (error) {
                commit(types.ERROR_ENTRIES, error);
            });
    },

    getEntries ({ commit, state }, journalId) {
        new Entry(state.jwt.token)
            .all(journalId)
            .then((response) => {
                commit(types.RECEIVE_ENTRIES, response.data.entries);
            })
            .catch(function (error) {
                commit(types.ERROR_ENTRIES, error);
            });
    },

    createNewEntry ({ commit, state, dispatch }, journalId) {
        new Entry(state.jwt.token)
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

    updateEntry({ commit, state, dispatch}, payload) {
        new Entry(state.jwt.token)
            .update(payload.entry, {
                title: payload.title,
                content: payload.content
            })
            .then((response) => {
                commit(types.UPDATE_ENTRY);
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    deleteEntry({ commit, state, dispatch}, entryId) {

        new Entry(state.jwt.token)
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
    getJournals ({ commit, state }) {
        new Journal(state.jwt.token)
            .all()
            .then((response) => {
                commit(types.RECEIVE_JOURNALS, response.data.journals);
            })
            .catch(function (error) {
                commit(types.ERROR_JOURNALS, error);
            });
    },

    createNewJournal({ commit, state, dispatch }, title) {
        new Journal(state.jwt.token)
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
    }
};