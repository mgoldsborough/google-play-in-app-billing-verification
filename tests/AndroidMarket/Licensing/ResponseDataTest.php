<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/android-market-license-verification/source/browse/trunk/LICENSE
 */

require_once 'AndroidMarket/Licensing/ResponseData.php';

class ResponseDataTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException AndroidMarket_Licensing_InvalidArgumentException
     * @dataProvider invalidArgumentTypeProvider
     */
    public function testConstructorThrowsWithOtherThanString($data)
    {
        new AndroidMarket_Licensing_ResponseData($data);
    }

    /**
     * @expectedException AndroidMarket_Licensing_InvalidArgumentException
     */
    public function testConstructorThrowsWithInvalidString()
    {
        new AndroidMarket_Licensing_ResponseData('this|doesnt|have|six|fields');
    }

    public function testConstructor()
    {
        $data = '0|1448316265|uk.co.davidcaunt.android.licensingtest|1|ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==|1308692145367';
        try {
            $response = new AndroidMarket_Licensing_ResponseData($data);
        } catch (AndroidMarket_Licensing_InvalidArgumentException $e) {
            $this->fail();
        }
        return $response;
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetResponseCode(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('int', $response->getResponseCode());
        $this->assertEquals(0, $response->getResponseCode());
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetNonce(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('string', $response->getNonce());
        $this->assertEquals(1448316265, $response->getNonce());
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetPackageName(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('string', $response->getPackageName());
        $this->assertEquals('uk.co.davidcaunt.android.licensingtest', $response->getPackageName());
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetVersionCode(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('int', $response->getVersionCode());
        $this->assertEquals(1, $response->getVersionCode());
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetUserId(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('string', $response->getUserId());
        $this->assertEquals('ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==', $response->getUserId());
    }

    /**
     *
     * @depends testConstructor
     */
    public function testGetTimestamp(AndroidMarket_Licensing_ResponseData $response)
    {
        $this->assertInternalType('float', $response->getTimestamp());
        $this->assertEquals(1308692145367, $response->getTimestamp());
    }

    public function testLicensedResponseIsLicensed()
    {
        $data = '0|1448316265|uk.co.davidcaunt.android.licensingtest|1|ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==|1308692145367';
        $response = new AndroidMarket_Licensing_ResponseData($data);

        $this->assertTrue($response->isLicensed());
    }

    public function testOldLicensedResponseIsLicensed()
    {
        $data = '2|1448316265|uk.co.davidcaunt.android.licensingtest|1|ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==|1308692145367';
        $response = new AndroidMarket_Licensing_ResponseData($data);

        $this->assertTrue($response->isLicensed());
    }

    public function testUnlicensedResponseIsNotLicensed()
    {
        $data = '1|1448316265|uk.co.davidcaunt.android.licensingtest|1|ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==|1308692145367';
        $response = new AndroidMarket_Licensing_ResponseData($data);

        $this->assertFalse($response->isLicensed());
    }

    /**
     * @dataProvider errorResponseCodeProvider
     */
    public function testErroneousResponseIsNotLicensed($responseCode)
    {
        $data = $responseCode . '|1448316265|uk.co.davidcaunt.android.licensingtest|1|ANlOHQOP0LkZ7Y0/zy7PIkZ2Nh5B73SgoA==|1308692145367';
        $response = new AndroidMarket_Licensing_ResponseData($data);

        $this->assertFalse($response->isLicensed());
    }

    public function invalidArgumentTypeProvider()
    {
        return array(
            array(1),
            array(0),
            array(false),
            array(true),
            array(''),
        );
    }

    public function errorResponseCodeProvider()
    {
        return array(
            array(3),
            array(4),
            array(5),
            array(101),
            array(102),
            array(103),
        );
    }
}