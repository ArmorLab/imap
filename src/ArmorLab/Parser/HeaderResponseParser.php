<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Message\MessageHeader;

class HeaderResponseParser
{
    /**
     * @param string[] $responseRows
     */
    public function parseResponse(string $uid, array $responseRows): MessageHeader
    {
        $date = $deliveryDate = $envelopeTo = $from = $to = $cc = $importance = '';

        foreach ($responseRows as $item) {
            if (\strpos($item, 'Delivery-date: ') !== false) {
                $deliveryDate = \str_replace('Delivery-date: ', '', $item);
            }

            if (\strpos($item, 'Date: ') !== false) {
                $date = \str_replace('Date: ', '', $item);
            }

            if (\strpos($item, 'Envelope-to: ') !== false) {
                $envelopeTo = \str_replace('Envelope-to: ', '', $item);
            }

            if (\strpos($item, 'From: ') !== false) {
                $from = \str_replace('From: ', '', $item);
            }

            if (\strpos($item, 'To: ') !== false) {
                $to = \str_replace('To: ', '', $item);
            }

            if (\strpos($item, 'Cc: ') !== false) {
                $cc = \str_replace('Cc: ', '', $item);
            }

            if (\strpos($item, 'Importance: ') !== false) {
                $importance = \str_replace('Importance: ', '', $item);
            }
        }

        return new MessageHeader(
            $uid,
            $date,
            $deliveryDate,
            $envelopeTo,
            $from,
            $to,
            $cc,
            $importance
        );
    }
}
