<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Command\FetchCommand;
use ArmorLab\Command\ListCommand;
use ArmorLab\Command\SearchCommand;
use ArmorLab\Message\MessageHeader;

class ImapDriver
{
    private Connection $connection;
    private FetchCommand $fetchCommand;
    private SearchCommand $searchCommand;
    private ListCommand $listCommand;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->fetchCommand = new FetchCommand($connection);
        $this->searchCommand = new SearchCommand($connection);
        $this->listCommand = new ListCommand($connection);
    }

    public function login(string $login, string $pwd): void
    {
        $this->connection->command(
            \sprintf('LOGIN %s "%s"', $login, $pwd)
        );
    }

    /**
     * Returns a subset of names from the set of names
     * that the user has declared as being "active" or "subscribed".
     * @return string[]
     */
    public function getSubscribedFolders(): array
    {
        return $this->listCommand->listSubscribed();
    }

    /**
     * @return string[]
     */
    public function getAllFolders(): array
    {
        return $this->listCommand->listAll();
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
        $ids = $this->searchCommand->search($criteria);
        $messages = [];
        foreach ($ids as $id) {
            $messages[] = $this->fetchCommand->fetchHeader($id);
        }

        return $messages;
    }
}
