<?php

declare(strict_types = 1);

namespace DocumentGenerator;

/**
 * parser interface.
 *
 * @author wolf
 */
interface ParserInterface
{
    /**
     * input data, output document.
     *
     * @param $data
     * @return array
     */
    public function parse ($data): array;
}