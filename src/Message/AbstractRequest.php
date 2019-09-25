<?php

namespace Omnipay\Windcave\Message;

/**
 * @link https://www.windcave.com.au/rest-docs/index.html
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /** @var string Endpoint URL */
    protected $endpoint = 'https://{{environment}}.windcave.com/api/v1';

    abstract public function getEndpoint();

    protected function baseEndpoint()
    {
        return str_replace('{{environment}}', $this->getTestMode() ? 'uat' : 'sec', $this->endpoint);
    }

    /**
     * Get API publishable key
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set API publishable key
     * @param  string $value API publishable key
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get Merchant
     * @return string Merchant ID
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set Merchant
     * @param  string $value Merchant ID
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get single-use token
     * @return string Token key
     */
    public function getSessionId()
    {
        return $this->getParameter('sessionId');
    }

    /**
     * Set single-use token
     * @param  string $value Token Key
     */
    public function setSessionId($value)
    {
        return $this->setParameter('sessionId', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getCurrency()
    {
        // Windcave expects lowercase currency values
        return ($this->getParameter('currency'))
            ? strtolower($this->getParameter('currency'))
            : null;
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getMerchantReference()
    {
        return $this->getParameter('merchantReference');
    }

    public function setMerchantReference($value)
    {
        return $this->setParameter('merchantReference', $value);
    }

    abstract public function getContentType();

    public function setContentType($value)
    {
        return $this->setParameter('contentType', $value);
    }

    /**
     * Get HTTP method
     * @return string HTTP method (GET, PUT, etc)
     */
    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * Get request headers
     * @return array Request headers
     */
    public function getRequestHeaders()
    {
        // common headers
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => $this->getContentType(),
        );

        return $headers;
    }

    /**
     * Send data request
     *
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|\Omnipay\Windcave\Message\Response
     */
    public function sendData($data)
    {
        $username = $this->getUsername();
        $apiKey = $this->getApiKey();

        $headers = $this->getRequestHeaders();
        $headers['Authorization'] = 'Basic ' . base64_encode($username . ':' . $apiKey);

        $body = $data ? json_encode($data) : null;

        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body,
            '1.2' // Enforce TLS v1.2
        );

        $this->response = new Response($this, json_decode($response->getBody()->getContents(), true));

        // save additional info
        $this->response->setHttpResponseCode($response->getStatusCode());

        return $this->response;
    }
}
