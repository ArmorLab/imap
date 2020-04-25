<?php

declare(strict_types=1);

namespace ArmorLab\Message;

class MessageHeader
{
    private string $uid;
    private string $date = '';
    private string $deliveryDate = '';
    private string $envelopeTo = '';
    private string $from = '';
    private string $to = '';
    private string $cc = '';
    private string $importance = '';

    public function __construct(
        string $uid,
        string $date,
        string $deliveryDate,
        string $envelopeTo,
        string $from,
        string $to,
        string $cc,
        string $importance
    ) {
        $this->uid = $uid;
        $this->date = $this->decodeString($date);
        $this->deliveryDate = $this->decodeString($deliveryDate);
        $this->envelopeTo = $this->decodeString($envelopeTo);
        $this->from = $this->decodeString($from);
        $this->to = $this->decodeString($to);
        $this->cc = $this->decodeString($cc);
        $this->importance = $this->decodeString($importance);
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDeliveryDate(): string
    {
        return $this->deliveryDate;
    }

    public function getEnvelopeTo(): string
    {
        return $this->envelopeTo;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getCc(): string
    {
        return $this->cc;
    }

    public function getImportance(): string
    {
        return $this->importance;
    }

    private function decodeString(string $stringToDecode): string
    {
        return (string) \iconv_mime_decode($stringToDecode, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8');
    }
}
