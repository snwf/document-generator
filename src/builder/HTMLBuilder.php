<?php

declare(strict_types = 1);

namespace DocumentGenerator\builder;

use DocumentGenerator\BuilderInterface;

/**
 * build document to HTML format
 *
 * @author wolf
 */
class HTMLBuilder implements BuilderInterface
{

    /**
     * @inheritDoc
     */
    public function build (array $data): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function store (array $data, string $file): void
    {
    }
}