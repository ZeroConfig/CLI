<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

interface TransformerInterface
{
    /**
     * Apply data transformations to the input and return an iterable result.
     *
     * @param iterable $input
     *
     * @return iterable
     */
    public function __invoke(iterable $input): iterable;
}
