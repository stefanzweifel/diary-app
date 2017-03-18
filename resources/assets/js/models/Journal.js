import Api from './Api.js';

export default class extends Api {

    /**
     * Get all Journals
     * @return {Promise}
     */
    all() {
        return this.get('/api/journals');
    }

    /**
     * Create a new Journal
     * @param  {string} title
     * @return {Promise}
     */
    create(title) {
        return this.post('/api/journals/', { title });
    }

}