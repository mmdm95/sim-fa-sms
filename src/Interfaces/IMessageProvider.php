<?php

namespace Sim\SMS\Interfaces;

interface IMessageProvider
{
    /**
     * @param array $numbers
     * @return static
     */
    public function setNumbers(array $numbers);

    /**
     * @return array
     */
    public function getNumbers(): array;

    /**
     * @param string $body
     * @return static
     */
    public function withBody(string $body);

    /**
     * @return string
     */
    public function getBody(): string;
}