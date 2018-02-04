<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Pcre;

use Iterator;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Pcre\MatchFilter
 */
class MatchFilterTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function validPatternProvider(): array
    {
        return [
            ['//'],
            ['/foo/'],
            ['#foo#']
        ];
    }

    /**
     * @dataProvider validPatternProvider
     *
     * @param string $pattern
     *
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(string $pattern): void
    {
        $this->assertInstanceOf(
            MatchFilter::class,
            new MatchFilter($pattern)
        );
    }

    /**
     * @return string[][]
     */
    public function invalidDelimitedPatternProvider(): array
    {
        /** @noinspection SpellCheckingInspection */
        return [
            ['afooa'],
            ['0bar0'],
            ['\\baz\\'],
            ['AfooA']
        ];
    }

    /**
     * @dataProvider invalidDelimitedPatternProvider
     *
     * @param string $pattern
     *
     * @return void
     * @covers ::__construct
     *
     * @expectedException              \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Delimiter must not be alphanumeric or backslash\. Encountered: [a-zA-Z0-9\\]/
     */
    public function testInvalidDelimiter(string $pattern): void
    {
        new MatchFilter($pattern);
    }

    /**
     * @return string[][]
     */
    public function missingEndingDelimiterPatternProvider(): array
    {
        return [
            ['/foo'],
            ['#foo'],
            ['|foo']
        ];
    }

    /**
     * @dataProvider missingEndingDelimiterPatternProvider
     *
     * @param string $pattern
     *
     * @return void
     * @covers ::__construct
     *
     * @expectedException              \InvalidArgumentException
     * @expectedExceptionMessageRegExp /No ending delimiter found for: ./
     */
    public function testMissingEndingDelimiter(string $pattern): void
    {
        new MatchFilter($pattern);
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
        $filter = new MatchFilter($pattern);

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
                '/^foo/',
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
                '/bar/i',
                [
                    'foo',
                    'bar',
                    'fooBar'
                ],
                [
                    'bar',
                    'fooBar'
                ]
            ],
            [
                '/foo/',
                ['bar'],
                []
            ]
        ];
    }
}
