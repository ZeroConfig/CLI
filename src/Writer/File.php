<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Writer;

class File extends AbstractWriter
{
    /** @var resource */
    private $handle;

    /**
     * Constructor.
     *
     * @param string $file
     * @param string $mode
     *
     * @see https://secure.php.net/manual/en/function.fopen.php
     */
    public function __construct(string $file, string $mode = 'w+')
    {
        $this->handle = fopen($file, $mode);
    }

    /**
     * Get the destination handle.
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }
}
