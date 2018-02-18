<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

use ZeroConfig\Cli\Csv\FormatConfiguratorInterface;
use ZeroConfig\Cli\Csv\FormatConfiguratorTrait;

class CsvWriter extends File implements FormatConfiguratorInterface
{
    use FormatConfiguratorTrait;

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

        foreach ($output as $row) {
            if (fputcsv(
                $handle,
                (array)$row,
                $this->delimiter,
                $this->enclosure,
                $this->escape
            ) === false) {
                break;
            }
        }
    }
}
