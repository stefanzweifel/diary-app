import Api from './Api.js';

export default class extends Api {

    /**
     * Get all Entries for a Journal
     * @param  {string} journalId
     * @return {Promise}
     */
    all(journalId) {
        return this.get(`/api/journals/${journalId}/entries`);
    }

    /**
     * Get a single Entry
     * @param  {string} id
     * @return {Promise}
     */
    find(id) {
        return this.get(`/api/entries/${id}/`);
    }

    /**
     * Create a new Entry
     * @param  {string} journalId
     * @return {Promise}
     */
    create(journalId) {
        return this.post(`/api/journals/${journalId}/entries`, {});
    }

    /**
     * Update a given Entry
     * @param  {string} entryId
     * @param  {object} payload
     * @return {Promise}
     */
    update(entryId, payload) {
        return this.patch(`/api/entries/${entryId}/`, payload);
    }

    /**
     * Delete a given Entry
     * @param  {string} entryId
     * @return {Promise}
     */
    destroy(entryId) {
        return this.delete(`/api/entries/${entryId}/`);
    }
}