<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 18/06/17
 * Time: 21:30
 */

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\PurchaseRequest;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest $request
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage You must pass a "card" parameter.
     */
    public function testGetDataInvalid()
    {
        $this->request->setCard(null);

        $this->request->getData();
    }

    public function testGetDataWithCard()
    {
        $card = $this->getValidCard();
        $this->request->setCard($card);

        $formPostEndpoint = 'https://sec.paymentexpress.com/pxmi3/E494B52F483B328E38A2D0EC9C9104A53891CD9F7DC26DF0BB9C2EBB0897F9855AEAF340A4A19600C';

        $this->request->setEndpoint($formPostEndpoint);

        $data = $this->request->getData();

        $expiryMonth = sprintf('%02d', $card['expiryMonth']);
        $expiryYear = substr($card['expiryYear'], -2);
        $name = $card['firstName'] . ' ' . $card['lastName'];

        $this->assertEquals($card['number'],    $data['CardNumber']);
        $this->assertEquals($expiryMonth,       $data['ExpiryMonth']);
        $this->assertEquals($expiryYear,        $data['ExpiryYear']);
        $this->assertEquals($name,              $data['CardHolderName']);
        $this->assertEquals($card['cvv'],       $data['Cvc2']);

        $this->assertEquals($formPostEndpoint, $this->request->getEndpoint());
    }
}
