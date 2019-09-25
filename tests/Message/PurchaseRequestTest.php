<?php

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\PurchaseRequest;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var \Omnipay\Windcave\Message\PurchaseRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'amount' => '10.00',
            'currency' => 'USD',
        ]);
    }

    public function testGetData()
    {
        $this->request->setCustomerNumber('ABC123');
        $this->request->setSessionId('EFG789');

        $data = $this->request->getData();

        $this->assertEquals('10.00',   $data['principalAmount']);
        $this->assertEquals('usd',     $data['currency']);
        $this->assertEquals('ABC123',  $data['customerNumber']);
        $this->assertEquals('EFG789',  $data['sessionId']);
    }
}
