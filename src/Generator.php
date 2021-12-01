<?php

declare(strict_types = 1);

namespace DocumentGenerator;

use DocumentGenerator\exception\ParserNotFoundException;
use DocumentGenerator\exception\BuilderNotFoundException;
use DocumentGenerator\exception\ComparerNotFoundException;

/**
 * combined executor of the generated plan
 *
 * @author wolf
 */
final class Generator
{
    /** @var bool store file switch */
    private bool $store = false;

    /** @var bool compare doc switch */
    private bool $compare = false;

    /**
     * @param ParserInterface   $parser
     * @param ComparerInterface $comparer
     * @param BuilderInterface  $builder
     */
    public function __construct (
        private ParserInterface $parser, private ComparerInterface $comparer, private BuilderInterface $builder
    ) {
    }


    /**
     * TODO: Finish it.
     * generate processing
     *
     * @return mixed
     * @throws ExceptionInterface
     */
    public function execute (): mixed
    {
        return true;
    }

    /**
     * store setter
     *
     * @param bool $store
     * @return $this
     */
    public function store (bool $store = false): Generator
    {
        $this->store = $store;

        return $this;
    }

    /**
     * compare setter
     *
     * @param bool $compare compare switch.
     * @return $this
     */
    public function compare (bool $compare = false): Generator
    {
        $this->compare = $compare;

        return $this;
    }

    /**
     * set new parser instance.
     *
     * @param string|ParserInterface $parser
     * @return $this
     * @throws ParserNotFoundException
     */
    public function setParser (string|ParserInterface $parser): Generator
    {
        if (is_string($parser)) {
            if (class_exists($parser)) {
                $parser = new $parser();
            } else {
                throw new ParserNotFoundException();
            }
        }

        $this->parser = $parser;

        return $this;
    }

    /**
     * set new comparer instance.
     *
     * @param string|ComparerInterface $comparer
     * @return $this
     * @throws ComparerNotFoundException
     */
    public function setComparer (string|ComparerInterface $comparer): Generator
    {
        if (is_string($comparer)) {
            if (class_exists($comparer)) {
                $comparer = new $comparer();
            } else {
                throw new ComparerNotFoundException();
            }
        }

        $this->compare = $comparer;

        return $this;
    }

    /**
     * set new builder instance.
     *
     * @param string|BuilderInterface $builder
     * @return $this
     * @throws BuilderNotFoundException
     */
    public function setBuilder (string|BuilderInterface $builder): Generator
    {
        if (is_string($builder)) {
            if (class_exists($builder)) {
                $builder = new $builder();
            } else {
                throw new BuilderNotFoundException();
            }
        }

        $this->builder = $builder;

        return $this;
    }
}