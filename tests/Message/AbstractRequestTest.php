<?php

namespace Omnipay\Windcave\Test\Message;

use Mockery;
use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\AbstractRequest;

class AbstractRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    public function testApiKey()
    {
        $this->assertSame($this->request, $this->request->setApiKey('abc123'));
        $this->assertSame('abc123', $this->request->getApiKey());
    }

    public function testApiKeySecret()
    {
        $this->assertSame($this->request, $this->request->setApiKeySecret('abc123'));
        $this->assertSame('abc123', $this->request->getApiKeySecret());
    }

    public function testUsername()
    {
        $this->assertSame($this->request, $this->request->setUsername('abc123'));
        $this->assertSame('abc123', $this->request->getUsername());
    }

    public function testUseSecretKey()
    {
        $this->assertSame($this->request, $this->request->setUseSecretKey('abc123'));
        $this->assertSame('abc123', $this->request->getUseSecretKey());
    }

    public function testSessionId()
    {
        $this->assertSame($this->request, $this->request->setSessionId('abc123'));
        $this->assertSame('abc123', $this->request->getSessionId());
    }

    public function testIdempotencyKey()
    {
        $this->assertSame($this->request, $this->request->setIdempotencyKey('abc123'));
        $this->assertSame('abc123', $this->request->getIdempotencyKey());
    }
}
