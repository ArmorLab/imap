<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

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

    public function testGetActiveFoldersFromMailbox(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver = new ImapDriver($connection);
        $connection
            ->expects($this->once())
            ->method('command')
            ->with('LSUB "" "*"')
            ->willReturn([]);

        $this->assertEquals([], $driver->getActiveFolders());
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
}
