<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Factory\MessageHeaderFactory;
use ArmorLab\Message\MessageHeader;

class HeaderResponseParser
{
    /**
     * @param string[] $responseRows
     */
    public function parseResponse(string $uid, array $responseRows): MessageHeader
    {
        $searchData = [
            'date' => 'Date: ',
            'deliveryDate' => 'Delivery-date: ',
            'envelopeTo' => 'Envelope-to: ',
            'from' => 'From: ',
            'to' => 'To: ',
            'cc' => 'Cc: ',
            'importance' => 'Importance: ',
        ];

        $messageHeaderData = [
            'uid' => $uid,
            'date' => '',
            'deliveryDate' => '',
            'envelopeTo' => '',
            'from' => '',
            'to' => '',
            'cc' => '',
            'importance' => '',
        ];

        foreach ($responseRows as $item) {
            foreach ($searchData as $key => $data) {
                if (\strpos($item, $data) !== false) {
                    $messageHeaderData[$key] = \str_replace($data, '', $item);
                }
            }
        }

        $factory = new MessageHeaderFactory;

        return $factory->createFromArray($messageHeaderData);
    }
}
