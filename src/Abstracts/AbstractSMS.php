<?php

namespace Sim\SMS\Abstracts;

use Closure;
use Sim\SMS\Interfaces\ISMS;
use Sim\SMS\SMSFactory;
use Sim\SMS\Utils\Curl;

abstract class AbstractSMS implements ISMS
{
    const ARABIC_NUMBERS = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    const PERSIAN_NUMBERS = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    const ENGLISH_NUMBERS = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    /**
     * @var array $parameters
     */
    protected $parameters = [];

    /**
     * @var array $sms_code_message
     */
    protected $sms_code_message = [];

    /**
     * @var array $urls
     */
    protected $urls = [];

    /**
     * @var bool $is_successful
     */
    protected $is_successful = false;

    /**
     * @var array $status
     */
    protected $status = [
        'code' => null,
        'message' => 'Unknown',
    ];

    /**
     * @var array $success_status
     */
    protected $success_status = [
        'code' => 0,
        'message' => 'عملیات با موفقیت انجام شد.',
    ];

    /**
     * @var string $unknown_message
     */
    protected $unknown_message = 'خطای نامشخص';

    /**
     * @var Closure|null $error_callback
     */
    protected $error_callback = null;

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function onError(Closure $callback)
    {
        $this->error_callback = $callback;
        return $this;
    }

    /**
     * @param string $url
     * @param array $data
     * @param string $method
     * @param array $extra_options
     * @return array
     */
    protected function request(string $url, array $data, string $method = SMSFactory::METHOD_POST, array $extra_options = [])
    {
        $prevTimezone = date_default_timezone_get();

        // set timezone to tehran - because it is a persian library
        date_default_timezone_set("Asia/Tehran");

        $response = Curl::request($url, $data, $method, $extra_options);

        // reset timezone to original
        date_default_timezone_set($prevTimezone);

        return $response;
    }

    /**
     * Reset is successful variable to default
     */
    protected function resetIsSuccessful()
    {
        $this->is_successful = false;
    }

    /**
     * Set status to library's success status
     */
    protected function setStatusToGeneralSuccess()
    {
        $this->status = $this->success_status;
    }
}