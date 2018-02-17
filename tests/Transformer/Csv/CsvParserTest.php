<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Csv;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Csv\CsvParser;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Csv\CsvParser
 */
class CsvParserTest extends TestCase
{
    /**
     * @dataProvider parserProvider
     *
     * @param string     $delimiter
     * @param string     $enclosure
     * @param string     $escape
     * @param array|null $header
     * @param string     $input
     * @param array|null $expected
     *
     * @return void
     *
     * @covers ::setHeader
     * @covers ::__invoke
     */
    public function testParser(
        string $delimiter,
        string $enclosure,
        string $escape,
        ?array $header,
        string $input,
        ?array $expected
    ): void {
        $parser = new CsvParser();
        $this->assertInstanceOf(CsvParser::class, $parser);

        $parser->setDelimiter($delimiter);
        $parser->setEnclosure($enclosure);
        $parser->setEscape($escape);
        $parser->setHeader($header);

        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            $expected !== null ? [$expected] : [],
            iterator_to_array($parser([$input]))
        );
    }

    /**
     * @return array
     */
    public function parserProvider(): array
    {
        return [
            [
                ',',
                '"',
                '\\',
                null,
                'Foo,Bar,"Baz"',
                ['Foo', 'Bar', 'Baz']
            ],
            [
                ':',
                '"',
                '\\',
                ['foo', 'bar', 'baz'],
                'Foo:Bar:"Baz"',
                [
                    'foo' => 'Foo',
                    'bar' => 'Bar',
                    'baz' => 'Baz'
                ]
            ],
            [
                ',',
                '"',
                '\\',
                ['foo', 'bar', 'baz', 'qux'],
                'Foo,Bar,"Baz"',
                null
            ],
            [
                ',',
                '"',
                '\\',
                ['foo', 'bar', 'baz'],
                'Foo,Bar,"Baz",Qux',
                null
            ]
        ];
    }

    /**
     * @return void
     * @covers ::__invoke
     * @covers ::setFirstLineIsHeader
     */
    public function testFirstLineAsHeader(): void
    {
        $lines = [
            'foo,bar,baz',
            'Foo,Bar,Baz'
        ];

        $parser = new CsvParser();
        $parser->setHeader(['first', 'second', 'third']);
        $parser->setFirstLineIsHeader(true);

        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            [
                [
                    'foo' => 'Foo',
                    'bar' => 'Bar',
                    'baz' => 'Baz'
                ]
            ],
            iterator_to_array($parser($lines)),
            'The first line should become the keys for each row.'
        );

        $parser->setFirstLineIsHeader(false);
        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            [
                [
                    'first' => 'foo',
                    'second' => 'bar',
                    'third' => 'baz'
                ],
                [
                    'first' => 'Foo',
                    'second' => 'Bar',
                    'third' => 'Baz'
                ]
            ],
            iterator_to_array($parser($lines)),
            'The configured header should become the keys for each row.'
        );

        $parser->setFirstLineIsHeader(true);
        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            [],
            iterator_to_array($parser(['foo,bar,baz'])),
            'With only one line, with the first as header, yields no results.'
        );
    }
}
