<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

use ReflectionFunction;

class TransformerFactory implements TransformerFactoryInterface
{
    /** @var callable */
    private $factory;

    /** @var int */
    private $numberOfParameters;

    /**
     * Constructor.
     *
     * @param callable $factory
     */
    public function __construct(callable $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create a transformer for the given arguments.
     *
     * @param string[] ...$arguments
     *
     * @return TransformerInterface
     */
    public function create(string ...$arguments): TransformerInterface
    {
        $factory = $this->factory;
        return $factory(...$arguments);
    }

    /**
     * Get the number of parameters required to execute the command.
     *
     * @return int
     */
    public function getNumberOfParameters(): int
    {
        if ($this->numberOfParameters === null) {
            $reflection               = new ReflectionFunction($this->factory);
            $this->numberOfParameters = $reflection->getNumberOfParameters();
        }

        return $this->numberOfParameters;
    }
}
