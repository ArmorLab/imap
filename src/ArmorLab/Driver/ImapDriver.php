<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Message\MessageHeader;
use ArmorLab\Parser\HeaderResponseParser;
use ArmorLab\Parser\ListResponseParser;

class ImapDriver
{
    private Connection $connection;
    private ListResponseParser $listResponseParser;
    private HeaderResponseParser $headerResponseParser;

    public function __construct(
        string $host,
        int $port,
        int $timeout = 15
    ){
        $this->connection = new Connection($host, $port, $timeout);
        $this->listResponseParser = new ListResponseParser();
        $this->headerResponseParser = new HeaderResponseParser();
    }

    public function login(string $login, string $pwd): void
    {
        $this->connection->command(
            \sprintf('LOGIN %s "%s"', $login, $pwd)
        );
    }

    /**
     * @return string[]
     */
    public function getActiveFolders(): array
    {
        $response = $this->connection->command('LSUB "" "*"');

        return $this->listResponseParser->parseResponse($response);
    }

    /**
     * @return string[]
     */
    public function getAllFolders(): array
    {
        $response = $this->connection->command('LIST "" "*"');
        
        return $this->listResponseParser->parseResponse($response);
    }

    public function selectFolder(string $folder): void
    {
        $this->connection->command("SELECT $folder");
    }

    /**
     * @return MessageHeader[]
     */
    public function search(string $criteria): array
    {
        $ids = $this->getUidsBySearchCriteria($criteria);
        $messages = [];
        foreach($ids as $id) {
            $messages[] = $this->getHeadersFromUid($id);
        }

        return $messages;
    }

    /**
     * @return string[]
     */
    private function getUidsBySearchCriteria(string $criteria): array
    {
        $response = $this->connection->command("SEARCH $criteria");

        if (\is_array($response) && \count($response) === 1) {
            $response = \str_replace('* SEARCH ', '', $response[0]);

            return explode(' ', $response);
        }

        return [];
    }

    private function getHeadersFromUid(string $uid): MessageHeader
    {
        $response = $this->connection->command("FETCH $uid BODY.PEEK[HEADER]");
        
        return $this->headerResponseParser->parseResponse($uid, $response);
    }
}
