<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

use ReflectionFunction;

class TransformerDefinition extends TransformerFactory implements
    TransformerDefinitionInterface
{
    /** @var callable */
    private $factory;

    /** @var string */
    private $usageDescription;

    /** @var int */
    private $numberOfParameters;

    /**
     * Constructor.
     *
     * @param callable $factory
     * @param string   $usageDescription
     */
    public function __construct(callable $factory, string $usageDescription)
    {
        $this->factory          = $factory;
        $this->usageDescription = $usageDescription;
        parent::__construct($factory);
    }

    /**
     * Get the usage description.
     *
     * @return string
     */
    public function getUsageDescription(): string
    {
        return $this->usageDescription;
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
