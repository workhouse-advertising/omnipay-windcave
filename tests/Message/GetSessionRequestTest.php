<?php

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\GetSessionRequest;

class GetSessionRequestTest extends TestCase
{
    /**
     * @var \Omnipay\Windcave\Message\GetSessionRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new GetSessionRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setSessionId('SESS01234');
    }

    public function testEndpoint()
    {
        $this->request->setTestMode(true);
        $this->assertSame('https://uat.windcave.com/api/v1/sessions/SESS01234', $this->request->getEndpoint());
        $this->request->setTestMode(false);
        $this->assertSame('https://sec.windcave.com/api/v1/sessions/SESS01234', $this->request->getEndpoint());
    }

    public function testGetData()
    {
        $this->assertNull($this->request->getData());
    }
}
