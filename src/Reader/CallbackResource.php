<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

class CallbackResource extends AbstractReader
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
     * Get an iterable source of data.
     *
     * @return iterable
     */
    public function __invoke(): iterable
    {
        return call_user_func($this->handler);
    }
}
