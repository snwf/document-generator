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
     * @inheritdoc
     */
    public function document (array $data): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function modify (): string
    {
        return '';
    }
}