<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Command\FetchCommand;
use ArmorLab\Command\ListCommand;
use ArmorLab\Command\LoginCommand;
use ArmorLab\Command\SearchCommand;
use ArmorLab\Command\SelectCommand;
use ArmorLab\Message\MessageHeader;

class ImapDriver
{
    private LoginCommand $loginCommand;
    private SelectCommand $selectCommand;
    private FetchCommand $fetchCommand;
    private SearchCommand $searchCommand;
    private ListCommand $listCommand;

    public function __construct(Connection $connection)
    {
        $this->loginCommand = new LoginCommand($connection);
        $this->selectCommand = new SelectCommand($connection);
        $this->fetchCommand = new FetchCommand($connection);
        $this->searchCommand = new SearchCommand($connection);
        $this->listCommand = new ListCommand($connection);
    }

    public function login(string $username, string $password): void
    {
        $this->loginCommand->login($username, $password);
    }

    public function selectFolder(string $folder): void
    {
        $this->selectCommand->select($folder);
    }

    /**
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
