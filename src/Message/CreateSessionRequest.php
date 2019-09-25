<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/create-session
 */
class CreateSessionRequest extends AbstractRequest
{
    public function getData()
    {
        return [

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
}
