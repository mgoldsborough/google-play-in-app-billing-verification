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
 * A representation of the data returned by the Google Play In-App Billing service
 *
 * @category   GooglePlay
 * @package    GooglePlay_Licensing
 */
class GooglePlayResponseData
{
    
	/**
	 * @var array
	 */
    protected $_orders;

    /**
     * @var integer
     */
    protected $_nonce;

    /**
     * @param string $responseData
     */
    public function  __construct($responseData)
    {
        if (!is_string($responseData)) {
            throw new GooglePlayInvalidArgumentException("Invalid response data, expected string");
        }
	
        $jsonResponse = json_decode($responseData);
        
        if(empty($jsonResponse->nonce))
        	throw new GooglePlayInvalidArgumentException("No nonce");
         
        $this->_nonce = $jsonResponse->nonce;
        
        if(empty($jsonResponse->orders))
        	throw new GooglePlayInvalidArgumentException("No orders");
        
        $_orders = array();
        
        foreach($jsonResponse->orders as $order) {
        	$gpOrder = new GooglePlayOrder($order);
        	array_push($_orders, $gpOrder);
        }
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
     * Get the array of orders
     *
     * @return string
     */
    public function getOrders()
    {
        return $this->_orders;
    }
}
