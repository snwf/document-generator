<?php

declare(strict_types = 1);

namespace DocumentGenerator\exception;

use DocumentGenerator\ExceptionInterface;

/**
 * exception basic class.
 *
 * @author wolf
 */
class Exception implements ExceptionInterface
{

    /**
     * @inheritDoc
     */
    public function __toString ()
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @inheritDoc
     */
    public function getCode ()
    {
        // TODO: Implement getCode() method.
    }

    /**
     * @inheritDoc
     */
    public function getFile ()
    {
        // TODO: Implement getFile() method.
    }

    /**
     * @inheritDoc
     */
    public function getLine ()
    {
        // TODO: Implement getLine() method.
    }

    /**
     * @inheritDoc
     */
    public function getMessage ()
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * @inheritDoc
     */
    public function getPrevious ()
    {
        // TODO: Implement getPrevious() method.
    }

    /**
     * @inheritDoc
     */
    public function getTrace ()
    {
        // TODO: Implement getTrace() method.
    }

    /**
     * @inheritDoc
     */
    public function getTraceAsString ()
    {
        // TODO: Implement getTraceAsString() method.
    }

    /**
     * @inheritDoc
     */
    public function store ()
    {
        // TODO: Implement store() method.
    }
}