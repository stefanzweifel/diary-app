import Api from './Api.js';
import axios from 'axios';

export default class extends Api {

    /**
     * Get fresh JWT Token
     * @return {Promise}
     */
    jwtToken() {
        return axios.get('/token');
    }

    /**
     * Get User information
     * @return {Promise}
     */
    me() {
        return this.get('/api/user');
    }

}