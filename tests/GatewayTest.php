<?php

namespace Omnipay\Windcave\Test;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\Windcave\Gateway;
use Omnipay\Windcave\Message\CreateSessionRequest;
use Omnipay\Windcave\Message\PurchaseRequest;

/**
 * @property Gateway gateway
 */
class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
    }

    public function testCreateSessionUsingStringAmount()
    {
        $request = $this->gateway->createSession([
            'amount' => '10.00',
            'currency' => 'AUD',
            'merchantReference' => 'ABC123',
        ]);

        $this->assertInstanceOf(CreateSessionRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());

        $data = $request->getData();

        $this->assertEquals('10.00',   $data['amount']);
        $this->assertEquals('AUD',     $data['currency']);
        $this->assertEquals('ABC123',  $data['merchantReference']);
    }

    public function testCreateSessionUsingMoney()
    {
        $request = $this->gateway->createSession([
            'currency' => 'AUD',
            'merchantReference' => 'ABC123',
        ]);

        $money = new Money(1000, new Currency('AUD'));

        $request->setMoney($money);

        $this->assertInstanceOf(CreateSessionRequest::class, $request);
        $this->assertSame($money, $request->getAmount());
        $this->assertSame('10.00', (new DecimalMoneyFormatter(new ISOCurrencies()))->format($request->getAmount()));

        $data = $request->getData();

        $this->assertEquals('10.00',   $data['amount']);
        $this->assertEquals('AUD',     $data['currency']);
        $this->assertEquals('ABC123',  $data['merchantReference']);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'card' => new CreditCard([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'number' => '424242424242',
                'expiryMonth' => '03',
                'expiryYear' => '2020',
                'cvv' => '123',
            ]),
        ]);

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $data = $request->getData();

        $this->assertEquals('424242424242',         $data['CardNumber']);
        $this->assertEquals('John Doe',             $data['CardHolderName']);
        $this->assertEquals('123',                  $data['Cvc2']);
        $this->assertEquals('03',                   $data['ExpiryMonth']);
        $this->assertEquals('20',                   $data['ExpiryYear']);
    }
}
