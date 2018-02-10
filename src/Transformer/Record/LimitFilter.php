<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Record;

use ZeroConfig\Cli\Transformer\TransformerInterface;

class LimitFilter implements TransformerInterface
{
    /** @var int */
    private $limit;

    /**
     * Constructor.
     *
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
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
        $numYielded = 0;

        foreach ($input as $record) {
            if ($numYielded++ >= $this->limit) {
                break;
            }

            yield $record;
        }
    }
}
