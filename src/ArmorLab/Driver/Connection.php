<?php

declare(strict_types=1);

namespace ArmorLab\Driver;

use ArmorLab\Exception\CommandException;
use ArmorLab\Exception\ConnectionException;

class Connection
{
    private $filePointer;
    private string $commandCounter = '00000001';

    public function __construct(
        string $host,
        int $port,
        int $timeout = 15
    ){
        if (!($this->filePointer = fsockopen($host, $port, $errno, $errstr, $timeout))) {
            throw new ConnectionException("Could not connect to host ($errno) $errstr");
        }

        if (!stream_set_timeout($this->filePointer, $timeout)) {
            throw new ConnectionException('Could not set timeout');
        }
    }

    public function command($command): array
    {
        $lastResponse = [];
        $lastEndline  = '';
        
        fwrite($this->filePointer, "$this->commandCounter $command\r\n");
        
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
