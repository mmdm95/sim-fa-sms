<?php

namespace Sim\SMS;

use Sim\SMS\Abstracts\AbstractMessageProvider;

class MessageProvider extends AbstractMessageProvider
{
    /**
     * @var array $numbers
     */
    protected $numbers = [];

    /**
     * @var string $body
     */
    protected $body = '';

    /**
     * {@inheritdoc}
     */
    public function setNumbers(array $numbers)
    {
        $this->numbers = $this->validateMobile($numbers);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(string $body)
    {
        $this->body = trim($body);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): string
    {
        return $this->body;
    }
}