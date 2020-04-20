<?php

declare(strict_types=1);

namespace ArmorLab\Message;

use InvalidArgumentException;

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

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public function __set($name, $value)
    {
        if ($name === 'uid') {
            throw new InvalidArgumentException('Uid cannot be set on created Message Header!');
        }

        $this->$name = \iconv_mime_decode($value, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8');
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
}
