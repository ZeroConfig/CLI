<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Writer\CsvWriter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\CsvWriter
 */
class CsvWriterTest extends TestCase
{
    /**
     * @dataProvider csvProvider
     *
     * @param string  $expected
     * @param array[] ...$rows
     *
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(string $expected, array ...$rows): void
    {
        $root = vfsStream::setup(
            sha1(__METHOD__),
            null,
            [
                'feed.csv' => ''
            ]
        );

        $file   = $root->getChild('feed.csv')->url();
        $writer = new CsvWriter($file);

        /** @noinspection PhpParamsInspection */
        $writer($rows);

        $this->assertEquals($expected, file_get_contents($file));
    }

    /**
     * @return array[][]|string[][]
     */
    public function csvProvider(): array
    {
        return [
            [''],
            [PHP_EOL, []],
            [
                "foo,bar,baz\n",
                ['foo', 'bar', 'baz']
            ],
            [
                "foo,bar,baz\nfoo,qux,quu\n",
                ['foo', 'bar', 'baz'],
                ['foo', 'qux', 'quu']
            ]
        ];
    }
}
