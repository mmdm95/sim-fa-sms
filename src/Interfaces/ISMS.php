<?php

namespace Sim\SMS\Interfaces;

use Closure;
use Sim\SMS\MessageProvider;

interface ISMS
{
    /**
     * SMS panel number
     *
     * @param string $number
     * @return static
     */
    public function fromNumber(string $number);

    /**
     * @param $username
     * @param $password
     * @return static
     */
    public function credit($username, $password);

    /**
     * @param string $parameter_name
     * @param $parameter_value
     * @return static
     */
    public function setParameter(string $parameter_name, &$parameter_value);

    /**
     * @param string $parameter_name
     * @param mixed|null $prefer
     * @return mixed
     */
    public function getParameter(string $parameter_name, $prefer = null);

    /**
     * @param MessageProvider $numbers
     * @return static
     */
    public function send(MessageProvider $numbers);

    /**
     * Number of remaining sms count
     *
     * @return float
     */
    public function getCredit(): float;

    /**
     * Returns an array with following format:
     * [
     *   code => the code after send (according to sms' codes table),
     *   message => the message of that code (according to sms' messages table)
     * ]
     *
     * @return array
     */
    public function getStatus(): array;

    /**
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * If anything than success happen
     *
     * @param Closure $callback
     * @return static
     */
    public function onError(Closure $callback);
}