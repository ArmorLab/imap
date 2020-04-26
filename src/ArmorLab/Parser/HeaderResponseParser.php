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
        $searchData = $this->getSearchData();
        $messageHeaderData = $this->prepareMessageHeaderData($uid);

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

    /**
     * @return string[]
     */
    private function getSearchData(): array
    {
        return [
            'date' => 'Date: ',
            'deliveryDate' => 'Delivery-date: ',
            'envelopeTo' => 'Envelope-to: ',
            'from' => 'From: ',
            'to' => 'To: ',
            'cc' => 'Cc: ',
            'importance' => 'Importance: ',
        ];
    }

    /**
     * @param string $uid
     * @return string[]
     *  [
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
    private function prepareMessageHeaderData(string $uid): array
    {
        return [
            'uid' => $uid,
            'date' => '',
            'deliveryDate' => '',
            'envelopeTo' => '',
            'from' => '',
            'to' => '',
            'cc' => '',
            'importance' => '',
        ];
    }
}
