<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Pcre;

use InvalidArgumentException;
use ZeroConfig\Cli\Transformer\TransformerInterface;

class MatchFilter implements TransformerInterface
{
    /** @var string */
    private $pattern;

    /**
     * Constructor.
     *
     * @param string $pattern
     *
     * @throws InvalidArgumentException When $pattern is not a valid PCRE pattern.
     */
    public function __construct(string $pattern)
    {
        // The first character will be the delimiter.
        $delimiter = substr($pattern, 0, 1);

        if (preg_match('/[a-z0-9\\\\]/i', $delimiter)) {
            throw new InvalidArgumentException(
                'Delimiter must not be alphanumeric or backslash. Encountered: '
                . $delimiter
            );
        }

        // Detect if the ending delimiter was found, excluding escaped delimiters
        // using a negative look behind.
        if (!preg_match(
            '/(?<!\\\\)' . "\\" . $delimiter . '/',
            substr($pattern, 1)
        )) {
            throw new InvalidArgumentException(
                'No ending delimiter found for: ' . $delimiter
            );
        }

        $this->pattern = $pattern;
    }

    /**
     * Apply data transformations to the input and return an iterable result.
     *
     * @param iterable $input
     *
     * @return iterable
     */
    public function __invoke(iterable $input): iterable
    {
        foreach ($input as $line) {
            if (preg_match($this->pattern, $line)) {
                yield $line;
            }
        }
    }
}
