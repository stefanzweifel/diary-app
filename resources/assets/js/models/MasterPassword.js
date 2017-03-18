import Api from './Api.js';

export default class extends Api {

    /**
     * Verify password against stored masterpassword
     * @param  {string} password
     * @return {Promise}
     */
    verify(password) {
        return this.post('/api/master-password/unlock', {
            password
        });
    }

    /**
     * Create a new Master Password
     * @param  {string} password
     * @param  {string} password_confirmation
     * @return {Promise}
     */
    create(password, password_confirmation) {
        return this.post('/api/master-password', {
            password,
            password_confirmation
        });
    }

}