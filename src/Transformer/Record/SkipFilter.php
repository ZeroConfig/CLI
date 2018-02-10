<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Record;

use ZeroConfig\Cli\Transformer\TransformerInterface;

class SkipFilter implements TransformerInterface
{
    /** @var int */
    private $offset;

    /**
     * Constructor.
     *
     * @param int $offset
     */
    public function __construct(int $offset)
    {
        $this->offset = $offset;
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
        $numSkipped = 0;

        foreach ($input as $record) {
            if ($numSkipped++ < $this->offset) {
                continue;
            }

            yield $record;
        }
    }
}
