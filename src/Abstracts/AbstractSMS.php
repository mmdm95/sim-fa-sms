<?php

namespace Sim\SMS\Abstracts;

use Closure;
use Sim\SMS\Interfaces\ISMS;

abstract class AbstractSMS implements ISMS
{
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
        $this->setParameter($name, $value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->getParameter($name);
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
    public function setParameter(string $parameter_name, &$parameter_value)
    {
        $this->parameters[$parameter_name] = $parameter_value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(string $parameter_name, $prefer = null)
    {
        return $this->parameters[$parameter_name] ?? $prefer;
    }

    /**
     *
     * status array is like below
     * [
     *   'code' => operation code,
     *   'message' => operation message
     * ]
     *
     * or an array of status array
     *
     * [
     *   [
     *     'code' => operation code,
     *     'message' => operation message
     *   ],
     *   [
     *     'code' => operation code,
     *     'message' => operation message
     *   ],
     *   ...
     * ]
     *
     * {@inheritdoc}
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful(): bool
    {
        return $this->is_successful;
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
     * @param array $data
     * @param string $url
     * @return mixed
     */
    abstract protected function request(array $data, string $url);

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