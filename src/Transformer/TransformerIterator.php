<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

use ArrayIterator;
use IteratorIterator;

class TransformerIterator extends IteratorIterator implements
    TransformerIteratorInterface
{
    /**
     * Constructor.
     *
     * @param TransformerInterface[] ...$transformers
     */
    public function __construct(TransformerInterface ...$transformers)
    {
        parent::__construct(
            new ArrayIterator($transformers)
        );
    }

    /**
     * Get the current transformer.
     *
     * @return TransformerInterface
     */
    public function current(): TransformerInterface
    {
        return parent::current();
    }
}
