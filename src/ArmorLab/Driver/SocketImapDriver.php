<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Message\MessageHeader;
use ArmorLab\Parser\ListResponseParser;

class SocketImapDriver
{
    private Connection $connection;

    public function __construct(
        string $host,
        int $port,
        int $timeout = 15
    ){
        $this->connection = new Connection($host, $port, $timeout);
    }

    public function login(string $login, string $pwd): void
    {
        $this->connection->command("LOGIN $login $pwd");
    }

    public function getActiveFolders(): array
    {
        $response = $this->connection->command('LSUB "" "*"');

        return ListResponseParser::parseResponse($response);
    }

    public function getAllFolders(): array
    {
        $response = $this->connection->command('LIST "" "*"');
        
        return ListResponseParser::parseResponse($response);
    }

    public function selectFolder(string $folder): void
    {
        $this->connection->command("SELECT $folder");
    }

    public function search(string $criteria): array
    {
        $ids = $this->getUidsBySearchCriteria($criteria);
        $messages = [];
        foreach($ids as $id) {
            $messages[] = $this->getHeadersFromUid($id);
        }

        return $messages;
    }

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
        $header = new MessageHeader($uid);
        
        foreach ($response as $item) {
            if (\strpos($item, 'Delivery-date: ') !== false) {
                $header->deliveryDate = \str_replace('Delivery-date: ', '', $item);
            }

            if (\strpos($item, 'Date: ') !== false) {
                $header->date = \str_replace('Date: ', '', $item);
            }

            if (\strpos($item, 'Envelope-to: ') !== false) {
                $header->envelopeTo = \str_replace('Envelope-to: ', '', $item);
            }

            if (\strpos($item, 'From: ') !== false) {
                $header->from = \str_replace('From: ', '', $item);
            }

            if (\strpos($item, 'To: ') !== false) {
                $header->to = \str_replace('To: ', '', $item);
            }

            if (\strpos($item, 'Cc: ') !== false) {
                $header->cc = \str_replace('Cc: ', '', $item);
            }

            if (\strpos($item, 'Importance: ') !== false) {
                $header->importance = \str_replace('Importance: ', '', $item);
            }
        }

        return $header;
    }
}
