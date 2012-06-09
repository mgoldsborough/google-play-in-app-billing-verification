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
 * A representation of the data returned by the licensing service
 *
 * @category   GooglePlay
 * @package    GooglePlay_Licensing
 */
class GooglePlayResponseData
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
    
    protected $_orders;
    
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
            throw new GooglePlayInvalidArgumentException("Invalid response data, expected string");
        }
	
        $jsonResponse = json_decode($responseData);
        $this->_nonce = $jsonResponse->nonce;
        
        $_orders = array();
        array_push($_orders, $jsonResponse->orders);
        
        echo 'JSON: ';
        print_r($jsonResponse);
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
