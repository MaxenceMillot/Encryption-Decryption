# Encryption-Decryption
PHP functions to encrypt and decrypt datas. Works with 2 keys. one client side and one server side

The encryption/decryption is valid for the duration of a PHP $_SESSION (and $_COOKIE).

The encryption is composed of an IV and a key. The key should be generated when a user is authenticated, then stored in a cookie or whatever other client-side container. When encrypt() is called, it takes the $data you wants to encrypt as a parameter.

Before encrypting, it will generated a unique IV which will be stored in the $_SESSION.

decrypt() takes the $data to decrypt as a parameter and will use the $_COOKIE['key'] and $_SESSION['iv'] to decrypt the datas.

resetKeyTimeout() will overwrite the cookie with the same value and with a duration of 20 minutes

For an extended use longer than a web session, key can be a fixed information (like a userid) and the iv can be stored elsewhere.

Given that it is an encryption and not an authentication, data integrity is not 100% ganteed
