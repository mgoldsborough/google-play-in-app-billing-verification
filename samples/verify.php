<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/android-market-license-verification-php/source/browse/trunk/LICENSE
 */

set_include_path(get_include_path() . PATH_SEPARATOR . '../library');

require_once 'AndroidMarket/Licensing/ResponseData.php';
require_once 'AndroidMarket/Licensing/ResponseValidator.php';

//Your key, copy and paste from https://market.android.com/publish/editProfile
define('PUBLIC_KEY', '');
//Your app's package name, e.g. com.example.yourapp
define('PACKAGE_NAME', '');

//The | delimited response data from the licensing server
$responseData = '';
//The signature provided with the response data (Base64)
$signature = '';

//if you wish to inspect or use the response data, you can create
//a response object and pass that in to the Validator's constructor
//$response = new AndroidMarket_Licensing_ResponseData($responseData);

$validator = new AndroidMarket_Licensing_ResponseValidator(PUBLIC_KEY, PACKAGE_NAME);
$valid = $validator->verify($responseData, $signature);

var_dump($valid);
