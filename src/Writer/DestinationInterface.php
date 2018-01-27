<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

interface DestinationInterface
{
    /**
     * Get the destination handle.
     *
     * @return resource
     */
    public function getHandle();
}
