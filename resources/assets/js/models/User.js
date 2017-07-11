import Api from './Api.js';

export default class extends Api {

    /**
     * Get User information
     * @return {Promise}
     */
    me() {
        return this.get('/api/user');
    }

}