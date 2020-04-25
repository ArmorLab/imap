<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Message\MessageHeader;
use PHPUnit\Framework\TestCase;

final class HeaderResponseParserTest extends TestCase
{
    public function testEmptyHeaderResponse(): void
    {
        $parser = new HeaderResponseParser;
        $result = $parser->parseResponse('', []);

        $this->assertInstanceOf(MessageHeader::class, $result);
        $this->assertEquals('', $result->getUid());
        $this->assertEquals('', $result->getDate());
        $this->assertEquals('', $result->getDeliveryDate());
        $this->assertEquals('', $result->getEnvelopeTo());
        $this->assertEquals('', $result->getFrom());
        $this->assertEquals('', $result->getImportance());
        $this->assertEquals('', $result->getTo());
        $this->assertEquals('', $result->getCc());
    }

    public function testHeaderResponseWithAllValues(): void
    {
        $parser = new HeaderResponseParser;
        $rows = [
            'Delivery-date: Thu, 23 Apr 2020 16:31:41 +0200',
            'Date: Thu, 23 Apr 2020 16:34:15 +0200',
            'Envelope-to: email',
            'From: sender',
            'To: receiver',
            'Cc: other receiver',
            'Importance: High',
        ];
        $result = $parser->parseResponse('172', $rows);

        $this->assertInstanceOf(MessageHeader::class, $result);
        $this->assertEquals('172', $result->getUid());
        $this->assertEquals('Thu, 23 Apr 2020 16:34:15 +0200', $result->getDate());
        $this->assertEquals('Thu, 23 Apr 2020 16:31:41 +0200', $result->getDeliveryDate());
        $this->assertEquals('email', $result->getEnvelopeTo());
        $this->assertEquals('sender', $result->getFrom());
        $this->assertEquals('High', $result->getImportance());
        $this->assertEquals('receiver', $result->getTo());
        $this->assertEquals('other receiver', $result->getCc());
    }

    public function testHeaderResponseForDifferentFormats(): void
    {
        $parser = new HeaderResponseParser;
        $rows = [
            'Date:Thu, 23 Apr 2020 16:34:15 +0200',
            ' From: sender',
            'To receiver',
        ];
        $result = $parser->parseResponse('172', $rows);

        $this->assertInstanceOf(MessageHeader::class, $result);
        $this->assertEquals('172', $result->getUid());
        $this->assertEquals('', $result->getDate());
        $this->assertEquals(' sender', $result->getFrom());
        $this->assertEquals('', $result->getTo());
    }
}
