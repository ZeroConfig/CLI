<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\String;

use Iterator;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\String\ContainsFilter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\String\ContainsFilter
 */
class ContainsFilterTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            ContainsFilter::class,
            new ContainsFilter('foo')
        );
    }

    /**
     * @dataProvider inputProvider
     *
     * @param string   $pattern
     * @param iterable $input
     * @param array    $expected
     *
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(
        string $pattern,
        iterable $input,
        array $expected
    ): void {
        $filter = new ContainsFilter($pattern);

        /** @var Iterator $result */
        $result = $filter($input);
        $this->assertEquals(
            $expected,
            iterator_to_array($result)
        );
    }

    /**
     * @return iterable[][]|string[][]|array[][]
     */
    public function inputProvider(): array
    {
        return [
            [
                'foo',
                [
                    'foo',
                    'bar',
                    'fooBar'
                ],
                [
                    'foo',
                    'fooBar'
                ]
            ],
            [
                'bar',
                [
                    'foo',
                    'bar',
                    'fooBar'
                ],
                [
                    'bar'
                ]
            ],
            [
                'foo',
                ['bar'],
                []
            ]
        ];
    }
}
