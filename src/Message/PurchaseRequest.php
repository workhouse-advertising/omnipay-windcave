<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\RequestInterface;

class PurchaseRequest extends AbstractRequest implements RequestInterface
{
    public function getData()
    {
        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        $this->getCard()->validate();

        $expiryMonth = str_pad($this->getCard()->getExpiryMonth(), 2, 0, STR_PAD_LEFT);
        $expiryYear = substr($this->getCard()->getExpiryYear(), -2);

        return [
            'CardNumber' => $this->getCard()->getNumber(),
            'ExpiryMonth' => $expiryMonth,
            'ExpiryYear' => $expiryYear,
            'CardHolderName' => $this->getCard()->getName(),
            'Cvc2' => $this->getCard()->getCvv(),
        ];
    }

    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    public function setEndpoint($value)
    {
        $this->setParameter('endpoint', $value);
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getContentType()
    {
        return 'multipart/form-data';
    }

    protected function wantsJson()
    {
        return false;
    }

    public function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
