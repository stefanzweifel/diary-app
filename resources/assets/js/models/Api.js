import axios from 'axios';

export default class {

    constructor(token) {
        this.token = token;
    }

    /**
     * Return HTTP Headers
     * @return {object}
     */
    headers() {
        return  {
            'Authorization': `Bearer ${this.token}`
        }
    }

    /**
     * Send GET Request
     * @param  {string} url
     * @return {Promise}
     */
    get(url) {
        return axios.get(url, {
            headers: this.headers()
        });
    }

    /**
     * Send POST Request
     * @param  {string} url
     * @param  {object} payload Data object to send
     * @return {Promise}
     */
    post(url, payload) {
        return axios.post(url, payload, {
            headers: this.headers()
        })
    }

    /**
     * Send PATCH Request
     * @param  {string} url
     * @param  {object} payload Data Object to send
     * @return {Promise}
     */
    patch(url, payload) {
        return axios.patch(url, payload, {
            headers: this.headers()
        })
    }

    /**
     * Send DELETE Request
     * @param  {string} url
     * @return {Promise}
     */
    deleteCall(url) {
        return axios.delete(url, {
            headers: this.headers()
        });
    }

}