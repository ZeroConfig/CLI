<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

use Iterator;

interface ReaderInterface extends Iterator
{
    /**
     * Get the current line.
     *
     * @return string
     */
    public function current(): string;
}
