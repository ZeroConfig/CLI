<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Sequence;

use Iterator;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Sequence\SkipFilter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Sequence\SkipFilter
 */
class SkipFilterTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            SkipFilter::class,
            new SkipFilter(42)
        );
    }

    /**
     * @dataProvider invokeProvider
     *
     * @param int   $offset
     * @param array $input
     * @param array $expected
     *
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(int $offset, array $input, array $expected): void
    {
        $filter = new SkipFilter($offset);

        /** @var Iterator $result */
        $result = $filter($input);

        $this->assertEquals($expected, iterator_to_array($result));
    }

    /**
     * @return int[][]|string[][][]
     */
    public function invokeProvider(): array
    {
        return [
            [
                3,
                ['foo', 'bar', 'baz'],
                [],
            ],
            [
                3,
                ['foo', 'bar', 'baz', 'qux', 'quu'],
                ['qux', 'quu'],
            ],
            [
                1,
                ['foo', 'bar', 'baz'],
                ['bar', 'baz'],
            ],
            [
                0,
                ['foo', 'bar', 'baz'],
                ['foo', 'bar', 'baz'],
            ],
            [
                5,
                ['foo', 'bar', 'baz'],
                [],
            ]
        ];
    }
}
