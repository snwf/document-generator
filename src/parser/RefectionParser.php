<?php

declare(strict_types = 1);

namespace DocumentGenerator\parser;

use DocumentGenerator\ParserInterface;

/**
 * parse file or string to array
 */
class RefectionParser implements ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse ($data): array
    {
        return [];
    }
}