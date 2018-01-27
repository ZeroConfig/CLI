<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

interface WriterInterface
{
    /**
     * Send the given output to a destination.
     *
     * @param iterable $output
     *
     * @return void
     */
    public function __invoke(iterable $output): void;
}
