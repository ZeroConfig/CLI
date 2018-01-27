<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

use SplFileObject;

class File extends AbstractReader
{
    /** @var string */
    private $file;

    /**
     * Constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Get an iterable source of data.
     *
     * @return iterable
     */
    public function __invoke(): iterable
    {
        return new SplFileObject($this->file, 'r');
    }
}
