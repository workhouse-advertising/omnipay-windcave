<?php

namespace Omnipay\Windcave\Message;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\RequestInterface;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/create-session
 */
class CreateSessionRequest extends AbstractRequest implements RequestInterface
{
    /**
     * @return string
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = [
            'type' => 'purchase',
            'currency' => $this->getCurrency(),
            'merchantReference' => $this->getMerchantReference(),
            'storeCard' => 0,
            'callbackUrls' => [
                'approved' => 'http://example.com?status=approved',
                'declined' => 'http://example.com?status=declined',
                'cancelled' => 'http://example.com?status=cancelled',
            ],
        ];

        // Has the Money class been used to set the amount?
        if ($this->getAmount() instanceof Money) {
            // Ensure principal amount is formatted as decimal string e.g. 50.00
            $data['amount'] = (new DecimalMoneyFormatter(new ISOCurrencies()))->format($this->getAmount());
        } else {
            $data['amount'] = $this->getAmount();
        }

        return json_encode($data);
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->baseEndpoint() . '/sessions';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getContentType()
    {
        return 'application/json';
    }

    public function getResponseClass()
    {
        return CreateSessionResponse::class;
    }
}
