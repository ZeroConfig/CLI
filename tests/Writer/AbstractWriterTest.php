<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Cli\Writer\AbstractWriter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\AbstractWriter
 */
class AbstractWriterTest extends TestCase
{
    /**
     * @dataProvider outputProvider
     *
     * @param iterable $output
     * @param string   $expected
     *
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(iterable $output, string $expected): void
    {
        $root = vfsStream::setup(
            sha1(__METHOD__),
            null,
            [
                'output.txt' => ''
            ]
        );

        $file = $root->getChild('output.txt');

        /** @var AbstractWriter|PHPUnit_Framework_MockObject_MockObject $writer */
        $writer = $this->getMockForAbstractClass(AbstractWriter::class);

        $writer
            ->expects(self::once())
            ->method('getHandle')
            ->willReturn(
                fopen($file->url(), 'w')
            );

        $writer->__invoke($output);

        $this->assertEquals(
            $expected,
            file_get_contents($file->url())
        );
    }

    /**
     * @return iterable[][]|string[][]
     */
    public function outputProvider(): array
    {
        return [
            [
                [],
                ''
            ],
            [
                ['foo'],
                'foo'
            ],
            [
                ['foo', 'bar', 'baz'],
                'foobarbaz'
            ]
        ];
    }
}
