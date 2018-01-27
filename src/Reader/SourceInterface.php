<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

interface SourceInterface
{
    /**
     * Get an iterable source of data.
     *
     * @return iterable
     */
    public function __invoke(): iterable;
}
