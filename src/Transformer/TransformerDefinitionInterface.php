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
     * Get the number of parameters required to execute the command.
     *
     * @return int
     */
    public function getNumberOfParameters(): int;
}
