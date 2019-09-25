<?php

namespace Omnipay\Windcave\Message;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * @link https://www.windcave.com.au/rest-docs/index.html#process-a-payment
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'customerNumber',
            'amount',
            'currency'
        );

        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        $this->getCard()->validate();

        // TODO
        $data = [
            'CardNumber' => '',
            'ExpiryMonth' => 'MM',
            'ExpiryYear' => 'YY',
            'CardHolderName' => '',
            'Cvc2' => '',
        ];

        return $data;
    }

    public function getEndpoint()
    {
        return $this->baseEndpoint() . '/transactions';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getContentType()
    {
        return 'multipart/form-data';
    }
}
