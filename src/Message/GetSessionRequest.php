<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Message\RequestInterface;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/query-session
 */
class GetSessionRequest extends AbstractRequest implements RequestInterface
{
    public function getSessionId()
    {
        return $this->getParameter('sessionId');
    }

    public function setSessionId($value)
    {
        return $this->setParameter('sessionId', $value);
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->baseEndpoint() . '/sessions/' . $this->getSessionId();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getContentType()
    {
        return 'application/json';
    }

    public function getResponseClass()
    {
        return GetSessionResponse::class;
    }
}
