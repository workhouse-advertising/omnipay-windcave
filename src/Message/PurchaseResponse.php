<?php

namespace Omnipay\Windcave\Message;

class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        $code = $this->getHttpResponseCode();

        return $code === 302 && $this->getStatus() === 'approved';
    }

    protected function getLocationAttribute($key)
    {
        $headers = $this->getHeaders();
        if (empty($headers['Location'][0])) {
            return null;
        }

        $location = parse_url($headers['Location'][0], PHP_URL_QUERY);
        parse_str($location, $query);

        return isset($query[$key]) ? $query[$key] : null;
    }

    public function getStatus()
    {
        return $this->getLocationAttribute('status');
    }

    public function getSessionId()
    {
        return $this->getLocationAttribute('sessionId');
    }
}
