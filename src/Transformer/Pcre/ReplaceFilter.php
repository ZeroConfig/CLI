<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Pcre;

class ReplaceFilter extends MatchFilter
{
    /** @var string */
    private $pattern;

    /** @var string */
    private $replacement;

    /**
     * Constructor.
     *
     * @param string $pattern
     * @param string $replacement
     */
    public function __construct(string $pattern, string $replacement)
    {
        parent::__construct($pattern);
        $this->pattern     = $pattern;
        $this->replacement = $replacement;
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
            yield preg_replace(
                $this->pattern,
                $this->replacement,
                $line
            ) ?? $line;
        }
    }
}
