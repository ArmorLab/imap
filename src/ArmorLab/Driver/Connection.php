<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Exception\CommandException;
use ArmorLab\Exception\ConnectionException;

class Connection
{
    /**
     * @var resource
     */
    private $filePointer;
    private string $commandCounter = '00000001';

    public function __construct(
        string $host,
        int $port,
        int $timeout = 15
    ){
        $filePointer = fsockopen('ssl://'.$host, $port, $errno, $errstr, $timeout);
        if ($filePointer === false) {
            throw new ConnectionException("Could not connect to host ($errno) $errstr");
        }

        $this->filePointer = $filePointer;

        if (!stream_set_timeout($this->filePointer, $timeout)) {
            throw new ConnectionException('Could not set timeout');
        }
    }

    /**
     * @return string[]
     */
    public function command(string $command): array
    {
        $lastResponse = [];
        $lastEndline  = '';
        $fullCommand = \sprintf("%s %s \r\n", $this->commandCounter, $command);
        
        fwrite($this->filePointer, $fullCommand);
        
        while ($line = fgets($this->filePointer)) {
            $line = trim($line);

            if(\strpos($line, $this->commandCounter) !== false) {
                $lastEndline = $line;
                break;
            }

            $lastResponse[] = $line;
        }
        
        $this->commandCounter = \sprintf('%08d', \intval($this->commandCounter) + 1);

        if (\strpos($lastEndline, 'OK') === false) {
            $this->close();
            throw new CommandException($lastEndline);
        }

        return $lastResponse;
    }
    
    private function close(): void
    {
        fclose($this->filePointer);
    }
}
