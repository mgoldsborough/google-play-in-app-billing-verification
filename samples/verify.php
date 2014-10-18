<?php

/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/mgoldsborough/google-play-in-app-billing-verification
 */

require_once '../library/GooglePlay/InAppBilling/GooglePlayRuntimeException.php';
require_once '../library/GooglePlay/InAppBilling/GooglePlayInvalidArgumentException.php';
require_once '../library/GooglePlay/InAppBilling/GooglePlayOrder.php';
require_once '../library/GooglePlay/InAppBilling/GooglePlayResponseData.php';
require_once '../library/GooglePlay/InAppBilling/GooglePlayResponseValidator.php';
echo 1;
//Your key, copy and paste from https://market.android.com/publish/editProfile
define('PUBLIC_KEY', '');
//Your app's package name, e.g. com.example.yourapp
define('PACKAGE_NAME', '');

//The | delimited response data from the licensing server
$responseData = '';
//The signature provided with the response data (Base64)
$signature = '';

//if you wish to inspect or use the response data, you can create
//a response object and pass it as the first argument to the Validator's verify method
//$response = new AndroidMarket_Licensing_ResponseData($responseData);
//$valid = $validator->verify($response, $signature);

$validator = new GooglePlayResponseValidator(PUBLIC_KEY, PACKAGE_NAME);
$valid = $validator->verify($responseData, $signature);

var_dump($valid);
