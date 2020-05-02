<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;

class SelectCommand
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function select(string $folderName): void
    {
        $this->connection->command(
            \sprintf('SELECT %s', $folderName)
        );
    }
}
