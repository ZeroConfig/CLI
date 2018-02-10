<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Record;

use Iterator;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Record\LimitFilter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Record\LimitFilter
 */
class LimitFilterTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            LimitFilter::class,
            new LimitFilter(42)
        );
    }

    /**
     * @dataProvider invokeProvider
     *
     * @param int   $limit
     * @param array $input
     * @param array $expected
     *
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(int $limit, array $input, array $expected): void
    {
        $filter = new LimitFilter($limit);

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
                ['foo', 'bar', 'baz'],
            ],
            [
                3,
                ['foo', 'bar', 'baz', 'qux', 'quu'],
                ['foo', 'bar', 'baz'],
            ],
            [
                1,
                ['foo', 'bar', 'baz'],
                ['foo'],
            ],
            [
                0,
                ['foo', 'bar', 'baz'],
                [],
            ],
            [
                5,
                ['foo', 'bar', 'baz'],
                ['foo', 'bar', 'baz'],
            ]
        ];
    }
}
