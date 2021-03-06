<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer;

interface TransformerDefinitionInterface
{
    /**
     * Get the usage description.
     *
     * @return string
     */
    public function getUsageDescription(): string;

    /**
     * Get the transformer factory.
     *
     * @return TransformerFactoryInterface
     */
    public function getFactory(): TransformerFactoryInterface;
}
