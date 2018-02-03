<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

class TransformerFactory implements TransformerFactoryInterface
{
    /** @var callable */
    private $factory;

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
}
