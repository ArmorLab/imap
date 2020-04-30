<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;
use ArmorLab\Message\MessageHeader;
use ArmorLab\Parser\HeaderResponseParser;

class FetchCommand
{
    private Connection $connection;

    private HeaderResponseParser $headerResponseParser;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->headerResponseParser = new HeaderResponseParser;
    }

    public function fetchHeader(string $uid): MessageHeader
    {
        $response = $this->connection->command("FETCH $uid BODY.PEEK[HEADER]");
        
        return $this->headerResponseParser->parseResponse($uid, $response);
    }
}