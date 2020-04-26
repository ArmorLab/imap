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
        $factory = new MessageHeaderFactory;
        $searchDataList = $this->getSearchData();
        $messageHeaderData = ['uid' => $uid];

        foreach ($searchDataList as $key => $searchData) {
            $messageHeaderData[$key] = $this->parseRow($responseRows, $searchData);
        }

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
     * @param string[] $rows
     */
    private function parseRow(array $rows, string $searchData): string
    {
        $parsedRow = '';
            
        foreach ($rows as $row) {
            if (\strpos($row, $searchData) !== false) {
                $parsedRow = \str_replace($searchData, '', $row);
            }
        }

        return $parsedRow;
    }
}
