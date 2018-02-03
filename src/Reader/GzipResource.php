<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

class GzipResource extends AbstractReader
{
    /** @var string */
    private $archive;

    /**
     * Constructor.
     *
     * @param string $archive
     */
    public function __construct(string $archive)
    {
        $this->archive = $archive;
    }

    /**
     * Get an iterable source of data.
     *
     * @return iterable
     */
    public function __invoke(): iterable
    {
        $handle = gzopen($this->archive, 'rb');

        while (!gzeof($handle)) {
            yield gzgets($handle);
        }

        gzclose($handle);
    }
}
