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
}
