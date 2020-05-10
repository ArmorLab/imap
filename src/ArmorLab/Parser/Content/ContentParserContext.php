<?php

declare(strict_types=1);

namespace ArmorLab\Parser\Content;

class ContentParserContext
{
    private ContentParserInterface $htmlParser;
    private ContentParserInterface $xhtmlParser;
    private ContentParserInterface $textParser;

    public function __construct()
    {
        $this->htmlParser = new HtmlParser;
        $this->xhtmlParser = new XhtmlParser;
        $this->textParser = new TextParser;
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

        if (\strpos($stringResponse, 'xhtml')) {
            return $this->xhtmlParser->parseContent($response);
        }

        return $this->textParser->parseContent($response);
    }
}
