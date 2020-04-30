<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;
use ArmorLab\Parser\SearchResponseParser;

class SearchCommand
{
    private Connection $connection;
    private SearchResponseParser $searchResponseParser;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->searchResponseParser = new SearchResponseParser;
    }

    public function search(string $criteria): array
    {
        $response = $this->connection->command("SEARCH $criteria");

        return $this->searchResponseParser->parseResponse($response);
    }
}
