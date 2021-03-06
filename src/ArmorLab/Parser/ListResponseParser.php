<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

use ArmorLab\Exception\CommandException;

class ListResponseParser
{
    /**
     * @param string[] $responseRows
     *
     * @return string[]
     */
    public function parseResponse(array $responseRows): array
    {
        $folders = [];

        /**
         * Example rows:
         * * LSUB () "." Spam
         * * LSUB () "." Spam
         */
        foreach ($responseRows as $item) {
            $rows = (array) preg_split('/ ("\/"|".") /', $item);
            
            if (\count($rows) < 2) {
                throw new CommandException('Unhandled response!');
            }

            $folders[] = \trim(\trim((string) $rows[1], '"'));
        }
        
        return $folders;
    }
}
