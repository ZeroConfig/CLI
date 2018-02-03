<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

use Iterator;

interface TransformerIteratorInterface extends Iterator
{
    /**
     * Get the current transformer.
     *
     * @return TransformerInterface
     */
    public function current(): TransformerInterface;
}
