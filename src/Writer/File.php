<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

use SplFileObject;

class File implements WriterInterface
{
    /** @var SplFileObject */
    private $writer;

    /**
     * Constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->writer = new SplFileObject($file, 'w+');
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
        foreach ($output as $line) {
            if ($this->writer->fwrite($line) === null) {
                break;
            }
        }
    }
}
