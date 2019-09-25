<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Response class for all Windcave requests
 */
class Response extends AbstractResponse
{
    /** @var string HTTP response code */
    protected $httpResponseCode = null;

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

        // TODO check response codes

        if ($code === 201) {   // Created
            return $this->isApproved();
        }

        if ($code === 202 && $this->isPending()) {   // Accepted
            return true;
        }

        return false;
    }

    /**
     * Is the transaction approved?
     * @return boolean True if approved
     */
    public function isApproved()
    {
        // TODO
        return false;
    }

    /**
     * Is the transaction pending?
     * @return boolean True if pending
     */
    public function isPending()
    {
        // TODO
        return false;
    }

    /**
     * Get Transaction ID
     * @return string|null
     */
    public function getTransactionId()
    {
        // TODO
        return null;
    }

    /**
     * Get Transaction reference
     * @return string Windcave transaction reference
     */
    public function getTransactionReference()
    {
        // TODO
        return null;
    }

    /**
     * Get status
     * @return array Returned status
     */
    public function getStatus()
    {
        // TODO
        return null;
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
     * Get error data from response
     * @param  string       $key Optional data key
     * @return string|array      Response error item or all data if no key
     */
    public function getErrorData($key = null)
    {
        if ($this->isSuccessful()) {
            return null;
        }
        // TODO
        return null;
    }

    /**
     * Get error message from the response
     * @return string|null Error message or null if successful
     */
    public function getMessage()
    {
        // TODO
        return null;
    }

    /**
     * Get code
     * @return string|null Error message or null if successful
     */
    public function getCode()
    {
        // TODO
        return null;
    }

    /**
     * Get Windcave Response Code
     * @return string Returned response code
     */
    public function getResponseCode()
    {
        // TODO check
        return $this->getData('responseCode');
    }

    /**
     * Get Windcave Response Text
     * @return string Returned response Text
     */
    public function getResponseText()
    {
        // TODO check
        return $this->getData('responseText');
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
     * @parm string Response Code
     */
    public function setHttpResponseCode($value)
    {
        $this->httpResponseCode = $value;
    }

    /**
     * Get HTTP Response code text
     * @return string
     */
    public function getHttpResponseCodeText()
    {
        $code = $this->getHttpResponseCode();
        $statusTexts = \Symfony\Component\HttpFoundation\Response::$statusTexts;

        return (isset($statusTexts[$code])) ? $statusTexts[$code] : null;
    }
}
