<?php

declare(strict_types=1);

namespace ArmorLab\Message;

class Message
{
    private MessageHeader $messageHeader;

    public function __construct(
        MessageHeader $messageHeader
    ) {
        $this->messageHeader = $messageHeader;
    }

    public function getHeader(): MessageHeader
    {
        return $this->messageHeader;
    }
}
