<?php

declare(strict_types=1);

namespace ArmorLab\Parser\Content;

class HtmlParser implements ContentParserInterface
{
    public function parseContent(array $response): string
    {
        $writeFlag = false;
        $content = '';
        foreach ($response as $row) {
            if ($row === '<html>') {
                $writeFlag = true;
            }

            if ($row === '</html>') {
                $writeFlag = false;
            }

            if ($writeFlag) {
                $content .= $row;
                if (substr($row, -1) !== '>') {
                    $content .= ' ';
                }
            }
        }

        return $content;
    }
}
