<?php

namespace Omnipay\Windcave\Message;

/**
 * Response class for all Windcave requests
 */
class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /** @var string HTTP response code */
    protected $httpResponseCode = null;

    protected $headers = [];

    /**
     * Is the transaction successful?
     * @return boolean True if successful
     */
    public function isSuccessful()
    {
        // get response code
        $code = $this->getHttpResponseCode();

        if ($code === 200) {  // OK
            return true;
        }

        if ($code === 202) {   // Accepted
            return true;
        }

        return false;
    }

    /**
     * Get response data, optionally by key
     * @param  string       $key Data array key
     * @return string|array      Response data item or all data if no key specified
     */
    public function getData($key = null)
    {
        if ($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }
        return $this->data;
    }

    /**
     * Get HTTP Response Code
     * @return string
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    /**
     * Set HTTP Response Code
     * @param $value
     */
    public function setHttpResponseCode($value)
    {
        $this->httpResponseCode = $value;
    }

    /**
     * Get headers array
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $value
     */
    public function setHeaders(array $value)
    {
        $this->headers = $value;
    }

    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            $errors = $this->getData('errors');
            return !empty($errors[0]['message']) ? $errors[0]['message'] : 'Unknown error';
        }

        return 'Success';
    }
}
