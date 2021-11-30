<?php

declare(strict_types = 1);

namespace DocumentGenerator;

/**
 * factory method
 *
 * @author wolf
 */
class Factory
{
    /**
     * return Generator executor.
     *
     * @param string|ParserInterface|null   $parser
     * @param string|ComparerInterface|null $comparer
     * @param string|BuilderInterface|null  $builder
     * @return Generator
     */
    public static function create (
        string|ParserInterface $parser = null, string|ComparerInterface $comparer = null, string|BuilderInterface $builder = null
    ): Generator {
        $parser = $parser instanceof ParserInterface ? $parser : new $parser();

        $comparer = $comparer instanceof ComparerInterface ? $comparer : new $comparer();

        $builder = $builder instanceof BuilderInterface ? $builder : new $builder();

        return new Generator($parser, $comparer, $builder);
    }
}