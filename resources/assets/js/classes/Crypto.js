/**
 * Custom implementation of `aes-js`
 *
 * https://github.com/ricmoo/aes-js
 */

import aesjs from 'aes-js';
import pbkdf2 from 'pbkdf2';

export default class {

    constructor (encryptionKey) {
        this.salt = window.Laravel.salt;
        this.encryptionKey = encryptionKey;

        this.key_256 = pbkdf2.pbkdf2Sync(this.encryptionKey, this.salt, 1, 256 / 8, 'sha512');
    }

    /**
     * Encrypt given String
     * @param  {string} stringToEncrypt
     * @return {string}
     */
    encrypt (stringToEncrypt) {

        // Convert text to bytes
        let textBytes = aesjs.utils.utf8.toBytes(stringToEncrypt);

        // The counter is optional, and if omitted will begin at 1
        let aesCtr = new aesjs.ModeOfOperation.ctr(this.key_256, new aesjs.Counter(5));
        let encryptedBytes = aesCtr.encrypt(textBytes);

        // To print or store the binary data, you may convert it to hex
        return aesjs.utils.hex.fromBytes(encryptedBytes);
    }

    /**
     * Decrypt given String
     * @param  {string} stringToDecrypt
     * @return {string}
     */
    decrypt (stringToDecrypt) {

        // When ready to decrypt the hex string, convert it back to bytes
        let encryptedBytes = aesjs.utils.hex.toBytes(stringToDecrypt);

        // The counter mode of operation maintains internal state, so to
        // decrypt a new instance must be instantiated.
        let aesCtr = new aesjs.ModeOfOperation.ctr(this.key_256, new aesjs.Counter(5));
        let decryptedBytes = aesCtr.decrypt(encryptedBytes);

        // Convert our bytes back into text
        return aesjs.utils.utf8.fromBytes(decryptedBytes);
    }

}