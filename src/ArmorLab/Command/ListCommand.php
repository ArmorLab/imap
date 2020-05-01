<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;
use ArmorLab\Parser\ListResponseParser;

class ListCommand
{
    private Connection $connection;
    private ListResponseParser $listResponseParser;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->listResponseParser = new ListResponseParser;
    }

    /**
     * Returns a subset of names from the complete set
     * of all names available to the client.
     * @return string[]
     */
    public function listAll(): array
    {
        $response = $this->connection->command('LIST "" "*"');
        
        return $this->listResponseParser->parseResponse($response);
    }

    /**
     * Returns a subset of names from the set of names
     * that the user has declared as being "active" or "subscribed".
     * @return string[]
     */
    public function listSubscribed(): array
    {
        $response = $this->connection->command('LSUB "" "*"');

        return $this->listResponseParser->parseResponse($response);
    }
}
