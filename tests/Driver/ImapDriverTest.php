<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Message\MessageHeader;
use PHPUnit\Framework\TestCase;

final class ImapDriverTest extends TestCase
{
    public function testLoginToMailbox(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('LOGIN email "password"');

        $this->assertNull($driver->login('email', 'password'));
    }

    public function testGetAllFoldersFromMailbox(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('LIST "" "*"')
            ->willReturn([]);

        $this->assertEquals([], $driver->getAllFolders());
    }

    public function testGetSubscribedFoldersFromMailbox(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('LSUB "" "*"')
            ->willReturn([]);

        $this->assertEquals([], $driver->getSubscribedFolders());
    }

    public function testSelectFolderFromMailbox(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('SELECT INBOX')
            ->willReturn([]);

        $this->assertNull($driver->selectFolder('INBOX'));
    }

    public function testSearchForEmptyResults(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('SEARCH ALL')
            ->willReturn([]);

        $this->assertEquals([], $driver->search('ALL'));
    }

    public function testSearchForSingleResultWithEmptyHeader(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $valueMap = [
            ['SEARCH ALL', ['* SEARCH 1']],
            ['FETCH 1 BODY.PEEK[HEADER]', []],
        ];
        $connection
            ->expects($this->any())
            ->method('command')
            ->will($this->returnValueMap($valueMap));
            
        $result = $driver->search('ALL');
        $messageHeader = $result[0];

        $this->assertInstanceOf(MessageHeader::class, $messageHeader);
        $this->assertEquals('1', $messageHeader->getUid());
        $this->assertEquals('', $messageHeader->getDate());
        $this->assertEquals('', $messageHeader->getDeliveryDate());
        $this->assertEquals('', $messageHeader->getEnvelopeTo());
        $this->assertEquals('', $messageHeader->getFrom());
        $this->assertEquals('', $messageHeader->getImportance());
        $this->assertEquals('', $messageHeader->getTo());
        $this->assertEquals('', $messageHeader->getCc());
    }
}
