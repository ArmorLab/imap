<?php

declare(strict_types=1);

namespace ArmorLab\Parser\Content;

interface ContentParserInterface
{
    /**
     * @param string[] $response
     */
    public function parseContent(array $response): string;
}
