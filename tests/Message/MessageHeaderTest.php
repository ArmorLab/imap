<?php

declare(strict_types=1);

namespace ArmorLab\Message;

use PHPUnit\Framework\TestCase;

final class MessageHeaderTest extends TestCase
{
    public function testMessageHeaderWithDecodedData(): void
    {
        $messageHeader = new MessageHeader(
            '321',
            'Thu, 23 Apr 2020 16:34:15 +0200',
            'Thu, 23 Apr 2020 16:34:15 +0200',
            'envelope to',
            '=?UTF-8?B?c2VuZGVy?=',
            '=?UTF-8?B?cmVjZWl2ZXI=?=',
            'carbon copy',
            'high'
        );

        $this->assertEquals('321', $messageHeader->getUid());
        $this->assertEquals('Thu, 23 Apr 2020 16:34:15 +0200', $messageHeader->getDate());
        $this->assertEquals('Thu, 23 Apr 2020 16:34:15 +0200', $messageHeader->getDeliveryDate());
        $this->assertEquals('envelope to', $messageHeader->getEnvelopeTo());
        $this->assertEquals('sender', $messageHeader->getFrom());
        $this->assertEquals('receiver', $messageHeader->getTo());
        $this->assertEquals('carbon copy', $messageHeader->getCc());
        $this->assertEquals('high', $messageHeader->getImportance());
    }
}
