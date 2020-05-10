<?php

declare(strict_types=1);

namespace ArmorLab\Command;

use ArmorLab\Driver\Connection;
use ArmorLab\Message\Message;
use ArmorLab\Message\MessageHeader;
use ArmorLab\Parser\Content\ContentParserContext;
use ArmorLab\Parser\HeaderResponseParser;

class FetchCommand
{
    private Connection $connection;
    private HeaderResponseParser $headerResponseParser;
    private ContentParserContext $contentParser;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->headerResponseParser = new HeaderResponseParser;
        $this->contentParser = new ContentParserContext;
    }

    public function fetchHeader(string $uid): MessageHeader
    {
        $response = $this->connection->command("FETCH $uid BODY.PEEK[HEADER]");
        
        return $this->headerResponseParser->parseResponse($uid, $response);
    }

    public function fetchMessage(string $uid): Message
    {
        $response = $this->connection->command("FETCH $uid BODY[1]");

        return new Message(
            $this->headerResponseParser->parseResponse($uid, $response),
            $this->contentParser->parseContent($response)
        );
    }
}
