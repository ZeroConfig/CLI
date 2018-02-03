<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

class HttpResource extends AbstractReader
{
    /** @var string */
    private $url;

    /**
     * Constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get an iterable source of data.
     *
     * @return iterable
     */
    public function __invoke(): iterable
    {
        $handle = fopen($this->url, 'r');

        while (!feof($handle)) {
            yield fgets($handle);
        }

        fclose($handle);
    }
}
