<?php

namespace Omnipay\Windcave\Message;

class CreateSessionResponse extends AbstractResponse
{
    public function getSessionId()
    {
        return $this->getData('id');
    }

    public function getState()
    {
        return $this->getData('state');
    }

    public function getPurchaseUrl()
    {
        $links = $this->getData('links');
        foreach ($links as $link) {
            if ($link['rel'] === 'submitCard') {
                return $link['href'];
            }
        }

        return null;
    }
}
