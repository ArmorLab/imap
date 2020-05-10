<?php

declare(strict_types=1);

namespace ArmorLab\Parser\Content;

class TextParser implements ContentParserInterface
{
    public function parseContent(array $response): string
    {
        unset($response[0]);
        unset($response[\count($response)]);

        $content = '';
        foreach($response as $row) {
            $content .= $row . "\n";
        }

        return $content;
    }
}
