<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\String;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\String\LineEnding;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\String\LineEnding
 */
class LineEndingTest extends TestCase
{
    /**
     * @dataProvider separatorProvider
     *
     * @param string $separator
     * @param array  $input
     * @param array  $expected
     *
     * @return void
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testInvoke(
        string $separator,
        array $input,
        array $expected
    ): void {
        $filter = new LineEnding($separator);

        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            $expected,
            iterator_to_array($filter($input))
        );
    }

    /**
     * @return string[][]|string[][][]
     */
    public function separatorProvider(): array
    {
        return [
            // Unix.
            [
                "\n",
                ['foo', 'bar', 'baz'],
                ["foo\n", "bar\n", "baz\n"]
            ],
            // Windows.
            [
                "\r\n",
                ['foo', 'bar', 'baz'],
                ["foo\r\n", "bar\r\n", "baz\r\n"]
            ],
            // Darwin.
            [
                "\r",
                ['foo', 'bar', 'baz'],
                ["foo\r", "bar\r", "baz\r"]
            ],
            // Tab.
            [
                "\t",
                ['foo', 'bar', 'baz'],
                ["foo\t", "bar\t", "baz\t"]
            ],
            // Elephant.
            [
                '🐘',
                ['foo', 'bar', 'baz'],
                ['foo🐘', 'bar🐘', 'baz🐘']
            ],
            // Safari.
            [
                '🐘🐍🦁🐵',
                ['foo', 'bar', 'baz'],
                ['foo🐘🐍🦁🐵', 'bar🐘🐍🦁🐵', 'baz🐘🐍🦁🐵']
            ]
        ];
    }
}
