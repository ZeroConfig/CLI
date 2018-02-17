<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

class CallbackWriter implements WriterInterface
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
     * Send the given output to a destination.
     *
     * @param iterable $output
     *
     * @return void
     */
    public function __invoke(iterable $output): void
    {
        call_user_func($this->handler, $output);
    }
}
