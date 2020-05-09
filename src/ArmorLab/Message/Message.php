<?php

declare(strict_types=1);

namespace ArmorLab\Message;

class Message
{
    private MessageHeader $messageHeader;
    private string $content;

    public function __construct(
        MessageHeader $messageHeader,
        string $content
    ) {
        $this->messageHeader = $messageHeader;
        $this->content = $content;
    }

    public function getHeader(): MessageHeader
    {
        return $this->messageHeader;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
