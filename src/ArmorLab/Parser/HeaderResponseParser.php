<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Message\MessageHeader;

class HeaderResponseParser
{
    public static function parseResponse(string $uid, array $responseRows): MessageHeader
    {
        $header = new MessageHeader($uid);
        
        foreach ($$responseRows as $item) {
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
