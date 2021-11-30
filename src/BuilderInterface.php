<?php

declare(strict_types = 1);

namespace DocumentGenerator;

/**
 * builder interface
 *
 * @author wolf
 */
interface BuilderInterface
{
    /**
     * input parse data, output format string
     *
     * @param array $data
     * @return string
     * @throws ExceptionInterface
     */
    public function build (array $data): string;

    /**
     * input parse data, store file to ram.
     *
     * @param array  $data
     * @param string $file
     * @throws ExceptionInterface
     */
    public function store (array $data, string $file): void;
}