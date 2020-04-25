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
        $this->assertEquals('', $result->getUid());
        $this->assertEquals('', $result->getTo());
        $this->assertEquals('', $result->getCc());
    }
}
