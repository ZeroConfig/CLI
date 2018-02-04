<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\TransformerFactory;
use ZeroConfig\Cli\Transformer\TransformerInterface;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\TransformerFactory
 */
class TransformerFactoryTest extends TestCase
{
    /**
     * @dataProvider factoryProvider
     *
     * @param callable $innerFactory
     * @param string[] ...$arguments
     *
     * @return void
     * @covers ::__construct
     * @covers ::create
     */
    public function testCreate(
        callable $innerFactory,
        string ...$arguments
    ): void {
        $factory = new TransformerFactory($innerFactory);
        $this->assertInstanceOf(
            TransformerInterface::class,
            $factory->create(...$arguments)
        );
    }

    /**
     * @return callable[][]|string[][]
     */
    public function factoryProvider(): array
    {
        return [
            [
                function () {
                    return $this->createMock(TransformerInterface::class);
                }
            ],
            [
                function (string $foo) {
                    return $this->createMock(TransformerInterface::class);
                },
                'foo'
            ],
            [
                function (string $foo, string $bar, string $baz) {
                    return $this->createMock(TransformerInterface::class);
                },
                'foo',
                'bar',
                'baz'
            ]
        ];
    }

    /**
     * @dataProvider factorySignatureProvider
     *
     * @param int      $expected
     * @param callable $innerFactory
     *
     * @return void
     * @covers ::__construct
     * @covers ::getNumberOfParameters
     */
    public function testGetNumberOfParameters(
        int $expected,
        callable $innerFactory
    ): void {
        $factory = new TransformerFactory($innerFactory);
        $this->assertEquals($expected, $factory->getNumberOfParameters());
    }

    /**
     * @return int[][]|callable[][]
     */
    public function factorySignatureProvider(): array
    {
        return [
            [
                0,
                function () {
                    // No body.
                }
            ],
            [
                1,
                function (string $foo) {
                    // No body.
                }
            ],
            [
                3,
                function (string $foo, int $bar, array $baz) {
                    // No body.
                }
            ]
        ];
    }
}
