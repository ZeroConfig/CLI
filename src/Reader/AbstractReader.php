<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

use Iterator;

abstract class AbstractReader implements
    SourceInterface,
    ReaderInterface
{
    /** @var Iterator */
    private $iterator;

    /**
     * Iterate over a fresh source.
     *
     * @return Iterator
     */
    private function getIterator(): Iterator
    {
        return $this->iterator;
    }

    /**
     * Set the pointer to the next line.
     *
     * @return void
     */
    public function next(): void
    {
        $this->getIterator()->next();
    }

    /**
     * Get the line number of the current line.
     *
     * @return int
     */
    public function key(): int
    {
        return $this->getIterator()->key();
    }

    /**
     * Check whether the current line is valid.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->getIterator()->valid();
    }

    /**
     * Re-open the source.
     *
     * @return void
     */
    public function rewind(): void
    {
        /** @var Iterator $iterator */
        $iterator       = $this->__invoke();
        $this->iterator = $iterator;
    }

    /**
     * Get the current line.
     *
     * @return string
     */
    public function current(): string
    {
        return $this->getIterator()->current();
    }
}
