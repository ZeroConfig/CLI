<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\TransformerDefinition;
use ZeroConfig\Cli\Transformer\TransformerFactoryInterface;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\TransformerDefinition
 */
class TransformerDefinitionTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            TransformerDefinition::class,
            new TransformerDefinition(
                function () {
                    // No body.
                },
                'Foo'
            )
        );
    }

    /**
     * @return void
     * @covers ::getUsageDescription
     */
    public function testGetUsageDescription(): void
    {
        $definition = new TransformerDefinition(
            function () {
                // No body.
            },
            'Foo'
        );
        $this->assertInternalType(
            'string',
            $definition->getUsageDescription()
        );
    }

    /**
     * @return void
     * @covers ::getFactory
     */
    public function testGetFactory(): void
    {
        $definition = new TransformerDefinition(
            function () {
                // No body.
            },
            'Foo'
        );
        $this->assertInstanceOf(
            TransformerFactoryInterface::class,
            $definition->getFactory()
        );
    }
}
