<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\TransformerInterface;
use ZeroConfig\Cli\Transformer\TransformerIterator;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\TransformerIterator
 */
class TransformerIteratorTest extends TestCase
{
    /**
     * @dataProvider transformerProvider
     *
     * @param TransformerInterface[] ...$transformers
     *
     * @return void
     * @covers ::__construct
     * @covers ::current
     */
    public function testIterator(TransformerInterface ...$transformers): void
    {
        $iterator = new TransformerIterator(...$transformers);

        $this->assertInstanceOf(TransformerIterator::class, $iterator);

        $numIterations = 0;
        foreach ($iterator as $transformer) {
            $this->assertInstanceOf(TransformerInterface::class, $transformer);
            $numIterations++;
        }

        $this->assertCount($numIterations, $transformers);
    }

    /**
     * @return TransformerInterface[][]
     */
    public function transformerProvider(): array
    {
        return [
            [],
            [
                $this->createMock(TransformerInterface::class)
            ],
            [
                $this->createMock(TransformerInterface::class),
                $this->createMock(TransformerInterface::class),
                $this->createMock(TransformerInterface::class)
            ]
        ];
    }
}
