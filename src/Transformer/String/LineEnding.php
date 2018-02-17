<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\String;

use ZeroConfig\Cli\Transformer\TransformerInterface;

class LineEnding implements TransformerInterface
{
    /** @var string */
    private $separator;

    /**
     * Constructor.
     *
     * @param string $separator
     */
    public function __construct(string $separator = PHP_EOL)
    {
        $this->separator = $separator;
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
        foreach ($input as $entry) {
            yield $entry . $this->separator;
        }
    }
}
