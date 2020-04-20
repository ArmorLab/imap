<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Exception\CommandException;

class ListResponseParser
{
    public static function parseResponse(array $responseRows): array
    {
        $folders = [];

        foreach ($responseRows as $item) {
            $rows = preg_split( '/ ("\/"|".") /', $item );
            
            if (\count($rows) < 2) {
                throw new CommandException('Unhandled response!');
            }

            $folders[] = \trim($rows[1], '"');
        }

        return $folders;
    }
}
