<?php

declare(strict_types=1);

namespace ArmorLab\Factory;

use ArmorLab\Message\MessageHeader;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

final class MessageHeaderFactoryTest extends TestCase
{
    public function testCreatingMessageHeaderFromArray(): void
    {
        $factory = new MessageHeaderFactory;
        $data = [
            'uid' => 'Uid',
            'date' => 'Date',
            'deliveryDate' => 'Delivery date',
            'envelopeTo' => 'Envelope to',
            'from' => 'From',
            'to' => 'To',
            'cc' => 'Carbon copy',
            'importance' => 'Importance',
        ];

        $result = $factory->createFromArray($data);

        $this->assertInstanceOf(MessageHeader::class, $result);
        $this->assertEquals('Uid', $result->getUid());
        $this->assertEquals('Date', $result->getDate());
        $this->assertEquals('Delivery date', $result->getDeliveryDate());
        $this->assertEquals('Envelope to', $result->getEnvelopeTo());
        $this->assertEquals('From', $result->getFrom());
        $this->assertEquals('To', $result->getTo());
        $this->assertEquals('Carbon copy', $result->getCc());
        $this->assertEquals('Importance', $result->getImportance());
    }

    public function testThrowErrorWhileBatchDataAreWrong(): void
    {
        $factory = new MessageHeaderFactory;
        $data = [
            'date' => 'Date',
            'deliveryDate' => 'Delivery date',
            'envelopeTo' => 'Envelope to',
            'from' => 'From',
            'to' => 'To',
            'cc' => 'Carbon copy',
            'importance' => 'Importance',
        ];

        $this->expectError(TypeError::class);

        $result = $factory->createFromArray($data);
    }
}
