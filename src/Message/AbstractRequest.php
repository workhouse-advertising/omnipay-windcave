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
    abstract public function getResponseClass();

    protected function baseEndpoint()
    {
        return str_replace('{{environment}}', $this->getTestMode() ? 'uat' : 'sec', $this->endpoint);
    }

    protected function wantsJson()
    {
        return true;
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
        return $this->getParameter('currency');
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
            'Content-Type' => $this->getContentType(),
            'User-Agent' => 'PostmanRuntime/7.17.1',
        );

        if ($this->wantsJson()) {
            $headers['Accept'] = 'application/json';
        }

        return $headers;
    }

    /**
     * Send data request
     *
     * @param $body
     *
     * @return \Omnipay\Common\Message\ResponseInterface|\Omnipay\Windcave\Message\Response
     */
    public function sendData($body)
    {
        $username = $this->getUsername();
        $apiKey = $this->getApiKey();

        $headers = $this->getRequestHeaders();
        $headers['Authorization'] = 'Basic ' . base64_encode($username . ':' . $apiKey);

        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body
        );

        $responseClass = $this->getResponseClass();

        $data = $response->getBody()->getContents();

        if ($this->wantsJson()) {
            $data = json_decode($data, true);
        }

        $this->response = new $responseClass($this, $data);

        // save additional info
        $this->response->setHttpResponseCode($response->getStatusCode());

        $this->response->setHeaders($response->getHeaders());

        return $this->response;
    }
}
