<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

class TransformerChain extends TransformerIterator implements TransformerInterface
{
    /**
     * Apply data transformations to the input and return an iterable result.
     *
     * @param iterable $input
     *
     * @return iterable
     */
    public function __invoke(iterable $input): iterable
    {
        $output = $input;

        foreach ($this as $transformer) {
            $output = $transformer($output);
        }

        return $output;
    }
}
