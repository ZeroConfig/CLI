<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Callback;

use ZeroConfig\Cli\Transformer\TransformerInterface;

class CallbackTransformer implements TransformerInterface
{
    /** @var callable */
    private $handler;

    /**
     * Constructor.
     *
     * @param callable $handler
     */
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
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
        return call_user_func($this->handler, $input);
    }
}
