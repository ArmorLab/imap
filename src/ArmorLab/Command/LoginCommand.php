<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;

class LoginCommand
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function login(string $username, string $password): void
    {
        $this->connection->command(
            \sprintf('LOGIN %s "%s"', $username, $password)
        );
    }
}
