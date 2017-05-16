import axios from 'axios';

export default class {

    /**
     * Send GET Request
     * @param  {string} url
     * @return {Promise}
     */
    get(url) {
        return axios.get(url);
    }

    /**
     * Send POST Request
     * @param  {string} url
     * @param  {object} payload Data object to send
     * @return {Promise}
     */
    post(url, payload) {
        return axios.post(url, payload)
    }

    /**
     * Send PATCH Request
     * @param  {string} url
     * @param  {object} payload Data Object to send
     * @return {Promise}
     */
    patch(url, payload) {
        return axios.patch(url, payload)
    }

    /**
     * Send DELETE Request
     * @param  {string} url
     * @return {Promise}
     */
    deleteCall(url) {
        return axios.delete(url);
    }

}