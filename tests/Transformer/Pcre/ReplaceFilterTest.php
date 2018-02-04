<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Pcre;

use Iterator;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;
use ZeroConfig\Cli\Transformer\Pcre\ReplaceFilter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Pcre\ReplaceFilter
 */
class ReplaceFilterTest extends TestCase
{
    /**
     * @dataProvider inputProvider
     *
     * @param string   $pattern
     * @param string   $replacement
     * @param iterable $input
     * @param array    $expected
     *
     * @return void
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testReplace(
        string $pattern,
        string $replacement,
        iterable $input,
        array $expected
    ): void {
        $filter = new ReplaceFilter($pattern, $replacement);

        $this->assertInstanceOf(MatchFilter::class, $filter);

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
        /** @noinspection SpellCheckingInspection */
        return [
            [
                '/^foo/',
                '',
                [
                    'foo',
                    'bar',
                    'fooBar'
                ],
                [
                    '',
                    'bar',
                    'Bar'
                ]
            ],
            [
                '/bar/i',
                'baz',
                [
                    'foo',
                    'bar',
                    'fooBar'
                ],
                [
                    'foo',
                    'baz',
                    'foobaz'
                ]
            ],
            [
                '/foo/',
                '',
                ['bar'],
                ['bar']
            ]
        ];
    }
}
