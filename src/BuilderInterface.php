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
     * input parse data, output build data.
     *
     * @param array $data
     * @return mixed
     * @throws ExceptionInterface
     */
    public function document (array $data): mixed;

    /**
     * input compare data, output build data.
     *
     * @return mixed
     */
    public function modify (): mixed;
}