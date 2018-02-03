<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

interface TransformerFactoryInterface
{
    /**
     * Create a transformer for the given arguments.
     *
     * @param string[] ...$arguments
     *
     * @return TransformerInterface
     */
    public function create(string ...$arguments): TransformerInterface;
}
