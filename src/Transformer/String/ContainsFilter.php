<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\String;

use ZeroConfig\Cli\Transformer\TransformerInterface;

class ContainsFilter implements TransformerInterface
{
    /** @var string */
    private $pattern;

    /**
     * Constructor.
     *
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Apply data transformations to the input and return an iterable result.
     *
     * @param iterable $input
     *
     * @return iterable
     */
    public function __invoke(iterable $input): iterable
    {
        foreach ($input as $line) {
            if (strpos($line, $this->pattern) !== false) {
                yield $line;
            }
        }
    }
}
