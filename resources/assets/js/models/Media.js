import Api from './Api.js';

export default class extends Api {

    /**
     * Get all Media element for an Entry
     * @param  {string} entryId
     * @return {Promise}
     */
    all(entryId) {
        return this.get(`/api/entries/${entryId}/media`);
    }

    /**
     * Create a new Media element
     * @param  {string} entryId
     * @param  {string} fileBlob
     * @return {Promise}
     */
    create(entryId, fileBlob) {
        let form = new FormData();
        form.append('file', fileBlob);

        return this.post(`/api/entries/${entryId}/media`, form);
    }

    /**
     * Delete a given Media Element
     * @param  {string} entryId
     * @param  {string} mediaId
     * @return {Promise}
     */
    destroy(entryId, mediaId) {
        return this.deleteCall(`/api/entries/${entryId}/media/${mediaId}`);
    }
}