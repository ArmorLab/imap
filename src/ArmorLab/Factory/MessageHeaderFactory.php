<?php

declare(strict_types=1);

namespace ArmorLab\Factory;

use ArmorLab\Message\MessageHeader;

class MessageHeaderFactory
{
    /**
     * @param string[] $messageHeaderData
     *  $messageHeaderData = [
     *      'uid' => (string) required,
     *      'date' => string,
     *      'deliveryDate' => (string),
     *      'envelopeTo' => (string),
     *      'from' => (string),
     *      'to' => (string),
     *      'cc' => (string),
     *      'importance' => (string),
     *  ]
     */
    public function createFromArray(array $messageHeaderData): MessageHeader
    {
        return new MessageHeader(
            $messageHeaderData['uid'],
            $messageHeaderData['date'],
            $messageHeaderData['deliveryDate'],
            $messageHeaderData['envelopeTo'],
            $messageHeaderData['from'],
            $messageHeaderData['to'],
            $messageHeaderData['cc'],
            $messageHeaderData['importance']
        );
    }
}
