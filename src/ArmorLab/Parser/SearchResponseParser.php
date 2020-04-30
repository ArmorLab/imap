<?php

declare(strict_types=1);

namespace ArmorLab\Parser;

class SearchResponseParser
{
    /**
     * @param string|string[] $response
     * @return string[]
     */
    public function parseResponse($response): array
    {
        if (\is_array($response) && \count($response) === 1) {
            $response = \str_replace('* SEARCH ', '', $response[0]);

            return explode(' ', $response);
        }

        return [];
    }
}
