<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Exception\CommandException;
use PHPUnit\Framework\TestCase;

class ListResponseParserTest extends TestCase
{
    public function testEmptyResponseWhileRowsAreEmpty(): void
    {
        $parser = new ListResponseParser;
        $rows = [];
        
        $result = $parser->parseResponse($rows);

        $this->assertEquals([], $result);
    }

    public function testExceptionWhileResponseRowIsWrong(): void
    {
        $parser = new ListResponseParser;
        $rows = [
            'some data"."ARCHIVE ',
        ];
        
        $this->expectException(CommandException::class);

        $result = $parser->parseResponse($rows);
    }

    public function testParsedData(): void
    {
        $parser = new ListResponseParser;
        $rows = [
            'unnecessary data "." INBOX',
            ' some other data "/" SENT ',
        ];
        
        $result = $parser->parseResponse($rows);

        $this->assertEquals('INBOX', $result[0]);
        $this->assertEquals('SENT', $result[1]);
    }
}
