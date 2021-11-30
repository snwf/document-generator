<?php

declare(strict_types = 1);

namespace DocumentGenerator\builder;

use DocumentGenerator\BuilderInterface;

/**
 * build document to Markdown format
 *
 * @author wolf
 */
class MarkdownBuilder implements BuilderInterface
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