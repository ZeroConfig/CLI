<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

abstract class AbstractWriter implements WriterInterface, DestinationInterface
{
    /**
     * Send the given output to the destination.
     *
     * @param iterable $output
     *
     * @return void
     */
    public function __invoke(iterable $output): void
    {
        $handle = $this->getHandle();

        foreach ($output as $line) {
            if (fwrite($handle, $line) === false) {
                break;
            }
        }
    }
}
