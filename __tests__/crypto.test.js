import Crypto from './../resources/assets/js/classes/Crypto.js';


describe('crypto-class', function() {

    beforeEach(() => {
        window.Laravel = {
            salt: 'base64:n2xyMxL55nQOMlpIUVgDRtlvKe6zLPCMf3lhZZBKT7M='
        };
    });

    test('it encrypts a given string', () => {

        let crypto = new Crypto('encryption-key');
        let string = 'This string will be encrypted';
        let encryptedString = crypto.encrypt(string);

        expect(string === encryptedString).toBeFalsy();

    });

    test('it decrypts an encrypted string', () => {

        let crypto = new Crypto('encryption-key');
        let string = 'This string will be encrypted';
        let encryptedString = 'd1daf756780a6c39fa772d3f7e54193386362079aa7d7a6b89ad820ec1';
        let decryptedString = crypto.decrypt(encryptedString);

        expect(decryptedString).toBe(string);
        expect(decryptedString === encryptedString).toBeFalsy();

    });

    test('it fails to decrypt value if encryption key has changed', () => {

        let crypto = new Crypto('encryption-key-is-different');
        let string = 'This string will be encrypted';
        let encryptedString = 'd1daf756780a6c39fa772d3f7e54193386362079aa7d7a6b89ad820ec1';
        let decryptedString = crypto.decrypt(encryptedString);

        expect(decryptedString === string).toBeFalsy();
        expect(decryptedString === encryptedString).toBeFalsy();

    });

    test('it fails to decrypt value if decrypted string has been modified', () => {

        let crypto = new Crypto('encryption-key');
        let encryptedString = 'xxxd1daf756780a6c39fa772d3f7e54193386362079aa7d7a6b89ad820ec1';

        expect(() => {
            crypto.decrypt(encryptedString)
        }).toThrow();
    });

    test('it fails to decrypt value if salt has been modified', () => {

        window.Laravel.salt = 'this-is-a-different-salt-string';

        let crypto = new Crypto('encryption-key');
        let string = 'This string will be encrypted';
        let encryptedString = 'd1daf756780a6c39fa772d3f7e54193386362079aa7d7a6b89ad820ec1';
        let decryptedString = crypto.decrypt(encryptedString);

        expect(decryptedString === string).toBeFalsy();
        expect(decryptedString === encryptedString).toBeFalsy();
    });

});