import * as types from './mutation-types.js';
import User from './../models/User.js';
import MasterPassword from './../models/MasterPassword.js';
import Journal from './../models/Journal.js';
import Entry from './../models/Entry.js';
import Media from './../models/Media.js';

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

    createNewEntry ({ commit }, journalId) {
        return new Entry()
            .create(journalId)
            .then((response) => {
                commit(
                    types.ADD_ENTRY,
                    response
                );
            })
    },

    updateEntry({ commit, dispatch }, payload) {
        new Entry()
            .update(payload.entryId, {
                title: payload.title,
                content: payload.content
            })
            .then((response) => {
                commit(types.UPDATE_ENTRY, response);
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
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    // ----------------------------------------------------------

    getMedia({commit, dispatch}, entryId) {
        new Media()
            .all(entryId)
            .then((response) => {
                commit('GET_MEDIA', response)
            })
            .catch((error) => {
                console.log(error);
            });
    },

    storeMedia({commit, dispatch}, payload ) {
        new Media()
            .create(payload.entryId, payload.blob)
            .then((response) => {
                commit('ADD_MEDIA', response)
                dispatch('getMedia', payload.entryId);
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    deleteMedia({commit, dispatch}, payload) {
        new Media()
            .destroy(payload.entryId, payload.mediaId)
            .then((response) => {
                console.log('DELETE');
            })
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