<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

use InvalidArgumentException;

class HttpResource extends AbstractReader
{
    /** @var string */
    private $url;

    /**
     * Constructor.
     *
     * @param string $url
     *
     * @throws InvalidArgumentException When the URL scheme is not http or https.
     */
    public function __construct(string $url)
    {
        $scheme = strtolower(
            parse_url($url, PHP_URL_SCHEME) ?? ''
        );

        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid URL "%s" with scheme "%s" supplied.',
                    $url,
                    $scheme
                )
            );
        }

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
