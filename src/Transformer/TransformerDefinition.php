<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

class TransformerDefinition extends TransformerFactory implements
    TransformerDefinitionInterface
{
    /** @var callable */
    private $factory;

    /** @var string */
    private $usageDescription;

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
     * Get the transformer factory.
     *
     * @return TransformerFactoryInterface
     */
    public function getFactory(): TransformerFactoryInterface
    {
        return $this;
    }
}
