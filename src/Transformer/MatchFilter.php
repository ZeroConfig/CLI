<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

use HylianShield\Validator\Pcre\ExpressionInterface;

class MatchFilter implements TransformerInterface
{
    /** @var string */
    private $pattern;

    /**
     * Constructor.
     *
     * @param ExpressionInterface $expression
     */
    public function __construct(ExpressionInterface $expression)
    {
        $this->pattern = $expression->getPattern();
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
