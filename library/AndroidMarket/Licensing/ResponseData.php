<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/android-market-license-verification/source/browse/trunk/LICENSE
 */

/**
 * A representation of the data returned by the licensing service
 *
 * @category   AndroidMarket
 * @package    AndroidMarket_Licensing
 */
class AndroidMarket_Licensing_ResponseData
{
    const LICENSED                   = 0x0;
    const NOT_LICENSED               = 0x1;
    const LICENSED_OLD_KEY           = 0x2;
    const ERROR_NOT_MARKET_MANAGED   = 0x3;
    const ERROR_SERVER_FAILURE       = 0x4;
    const ERROR_OVER_QUOTA           = 0x5;

    const ERROR_CONTACTING_SERVER    = 0x101;
    const ERROR_INVALID_PACKAGE_NAME = 0x102;
    const ERROR_NON_MATCHING_UID     = 0x103;
    
    /**
     * @var integer
     */
    protected $_responseCode;

    /**
     * @var integer
     */
    protected $_nonce;

    /**
     * @var string
     */
    protected $_packageName;

    /**
     * @var integer
     */
    protected $_versionCode;

    /**
     * @var string
     */
    protected $_userId;

    /**
     * @var integer
     */
    protected $_timestamp;

    /**
     * @param string $responseData
     */
    public function  __construct($responseData)
    {
        if (!is_string($responseData)) {
            require_once 'AndroidMarket/Licensing/InvalidArgumentException.php';
            throw new InvalidArgumentException("Invalid response data, expected string");
        }

        $parts = explode(':', $responseData);

        $data = $parts[0];
        $fields = explode('|', $data);

        if (count($fields) != 6) {
            require_once 'AndroidMarket/Licensing/InvalidArgumentException.php';
            throw new InvalidArgumentException("Wrong number of fields, expected 6");
        }

        list($this->_responseCode, $this->_nonce, $this->_packageName, $this->_versionCode, $this->_userId, $this->_timestamp) = $fields;
    }

    /**
     * Get the license status or error code
     *
     * @return integer
     */
    public function getResponseCode()
    {
        return (int)$this->_responseCode;
    }

    /**
     * Get one-time nonce
     * 
     * @return string
     */
    public function getNonce()
    {
        return $this->_nonce;
    }

    /**
     * Get the application package name
     *
     * @return string
     */
    public function getPackageName()
    {
        return $this->_packageName;
    }

    /**
     * Get the application version code
     *
     * @return integer
     */
    public function getVersionCode()
    {
        return (int)$this->_versionCode;
    }

    /**
     * Get the user identifier
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Get the response timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return (int)$this->_timestamp;
    }

    /**
     * If server response was licensed
     *
     * @return bool
     */
    public function isLicensed()
    {
        return (self::LICENSED == $this->_responseCode
               || self::LICENSED_OLD_KEY == $this->_responseCode);
    }

}
