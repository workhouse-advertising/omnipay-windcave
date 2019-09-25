<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/create-session
 */
class CreateSessionRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return [
            'type' => 'purchase',
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'merchantReference' => $this->getMerchantReference(),
            'storeCard' => 0,
            'callbackUrls' => [
                'approved' => 'http://ptsv2.com/t/4jita-1569373433/post'
            ],
        ];
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
}
