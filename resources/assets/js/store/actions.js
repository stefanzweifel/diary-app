import axios from 'axios';
import * as types from './mutation-types.js';

export default {
    jwtToken ({ commit, state, dispatch }) {
        axios.get('/token')
            .then((response) => {
                commit(types.GET_JWT_TOKEN, response.data);

                // When we get the Token, we then start loading the journals
                dispatch('getUser');
            })
    },

    getUser ({ commit, state}) {
        axios.get('/api/user', {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.GET_USER, response.data.user);
        })
        .catch(function (error) {
            commit(types.ERROR_JOURNALS, error);
        });
    },

    createMasterPassword ({ commit, state, dispatch }, payload) {
        axios.post('/api/master-password', {
            password: payload.password,
            password_confirmation: payload.password_confirmation
        }, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.MASTERPASSWORD_CREATED);
            dispatch('getUser');
        })
        .catch(function (error) {
            commit(types.ERROR_JOURNALS, error);
        });
    },

    // Unlock Account by checking Password against Master Password
    unlock ({ commit, state, dispatch }, payload) {
        axios.post('/api/master-password/unlock', {
            password: payload.password
        }, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
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

    // Load Journals
    getJournals ({ commit, state }) {
        axios.get('/api/journals', {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.RECEIVE_JOURNALS, response.data.journals);
        })
        .catch(function (error) {
            commit(types.ERROR_JOURNALS, error);
        });
    },

    getEntry({ commit, state}, entryId) {
        axios.get(`/api/entries/${entryId}/`, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.SELECT_ENTRY, response.data.entry);
        })
        .catch(function (error) {
            commit(types.ERROR_ENTRIES, error);
        });
    },

    getEntries ({ commit, state }, journalId) {
        axios.get(`/api/journals/${journalId}/entries`, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.RECEIVE_ENTRIES, response.data.entries);
        })
        .catch(function (error) {
            commit(types.ERROR_ENTRIES, error);
        });
    },

    createNewEntry ({ commit, state, dispatch }, journalId) {
        axios.post(`/api/journals/${journalId}/entries`, {}, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.ADD_ENTRY);
            dispatch('getEntries', journalId);
        })
        .catch(function (error) {
            console.log(error);
            // commit(types.ERROR_ENTRIES, error);
        });
    },

    updateEntry({ commit, state, dispatch}, entry) {
        axios.patch(`/api/journals/${state.active_journal.id}/entries/${state.active_entry.id}`,
        {
            title: entry.title,
            content: entry.content
        },
        {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.UPDATE_ENTRY);
            // dispatch('getEntries');
        })
        .catch(function (error) {
            console.log(error);
            // commit(types.ERROR_ENTRIES, error);
        });
    },

    deleteEntry({ commit, state, dispatch}) {
        axios.delete(`/api/entries/${state.active_entry.id}`,
        {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
        .then((response) => {
            commit(types.DELETE_ENTRY);
            dispatch('getEntries');
        })
        .catch(function (error) {
            console.log(error);
            // commit(types.ERROR_ENTRIES, error);
        });
    },

    createNewJournal({ commit, state, dispatch }, title) {
        axios.post(`/api/journals/`, { title: title}, {
            headers: {
                'Authorization': `Bearer ${state.jwt.token}`
            }
        })
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