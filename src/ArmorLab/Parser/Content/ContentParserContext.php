<?php

declare(strict_types=1);

namespace ArmorLab\Parser\Content;

class ContentParserContext
{
    private ContentParserInterface $htmlParser;
    private ContentParserInterface $xhtmlParser;

    public function __construct()
    {
        $this->htmlParser = new HtmlParser;
        $this->xhtmlParser = new XhtmlParser;
    }

    /**
     * @param string[] $response
     */
    public function parseContent(array $response): string
    {
        $stringResponse = \implode('', $response);
        if (\strpos($stringResponse, 'Content-Type: text/html;')) {
            return $this->htmlParser->parseContent($response);
        }

        return $this->xhtmlParser->parseContent($response);
    }
}
