<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

class StandardError extends AbstractWriter
{
    /**
     * Get the destination handle.
     *
     * @return resource
     */
    public function getHandle()
    {
        return STDERR;
    }
}
