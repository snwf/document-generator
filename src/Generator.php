<?php

declare(strict_types = 1);

namespace DocumentGenerator;

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
     * @return $this
     */
    public function compare (bool $compare = false): Generator
    {
        $this->compare = $compare;

        return $this;
    }
}