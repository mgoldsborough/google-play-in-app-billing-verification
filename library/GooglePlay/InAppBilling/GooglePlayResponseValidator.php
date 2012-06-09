<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * It is also available through the world-wide-web at this URL:
 * https://github.com/MG2Innovations/google-play-license-verification/blob/master/LICENSE
 */

/**
 * Verifies a response from the Google Play In-App Billing server.
 *
 * @category   GooglePlay
 * @package    GooglePlay_Licensing
 */
class GooglePlayResponseValidator  {

    const SIGNATURE_ALGORITHM = OPENSSL_ALGO_SHA1;

    const KEY_PREFIX = "-----BEGIN PUBLIC KEY-----\n";
    const KEY_SUFFIX = '-----END PUBLIC KEY-----';

    /**
     * OpenSSL public key
     *
     * @var resource
     */
    protected $_publicKey;

    /**
     * Application package name
     *
     * @var string
     */
    protected $_packageName;

    /**
     *
     * @param string $publicKey   Base64-encoded representation of your public key
     * @param string $packageName An optional package name to verify
     */
    public function  __construct($publicKey, $packageName = null)
    {        
        $key = self::KEY_PREFIX . chunk_split($publicKey, 64, "\n") . self::KEY_SUFFIX;
        $key = openssl_get_publickey($key);
        if (false === $key) {
            throw new GooglePlayInvalidArgumentException(
                    'Please pass a Base64-encoded public key from the Market portal');
        }
        $this->_publicKey   = $key;
        $this->_packageName = $packageName;
    }

    /**
     * Verifies that the response was signed with the given signature
     * and, optionally, for the right package
     * 
     * @param  GooglePlayLicensingResponseData|string $responseData
     * @param  string $signature
     * @return bool
     */
    public function verify($responseData, $signature)
    {
        if ($responseData instanceof GooglePlayResponseData) {
            $response = $responseData;
        } else {
            $response = new GooglePlayResponseData($responseData);
        }

        //check package name is valid
        if (!empty($packageName) && $packageName !== $response->getPackageName()) {
            return false;
        }

        $result = openssl_verify($responseData, base64_decode($signature),
                                 $this->_publicKey, self::SIGNATURE_ALGORITHM);

        //openssl_verify returns 1 for a valid signature
        if (0 === $result) {
            return false;
        } else if (1 !== $result) {
            throw new GooglePlayRuntimeException(
                    'Unknown error verifying the signature in openssl_verify');
        }

        return true;
    }

}
