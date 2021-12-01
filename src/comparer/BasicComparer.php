<?php

declare(strict_types = 1);

namespace DocumentGenerator\comparer;

use DocumentGenerator\ComparerInterface;

/**
 * basic comparer, store json file.
 *
 * @author wolf
 */
class BasicComparer implements ComparerInterface
{

    public function compare (array $last_doc, array $new_doc): array
    {
        return [];
    }
}