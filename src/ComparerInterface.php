<?php

declare(strict_types = 1);

namespace DocumentGenerator;

/**
 * compare difference.
 *
 * @author wolf
 */
interface ComparerInterface
{
    /**
     * compare document change.
     *
     * @param array $last_doc
     * @param array $new_doc
     * @return array
     */
    public function compare (array $last_doc, array $new_doc): array;
}