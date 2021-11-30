<?php

declare(strict_types = 1);

namespace DocumentGenerator;

use Throwable;

/**
 * base exception interface
 *
 * @author wolf
 */
interface ExceptionInterface extends Throwable
{
    /**
     * persistent error
     *
     * @throws self
     */
    public function store ();
}