<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Writer\CallbackWriter;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\CallbackWriter
 */
class CallbackWriterTest extends TestCase
{
    /**
     * @dataProvider writerProvider
     *
     * @param callable $handle
     * @param array    $input
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testWriter(callable $handle, array $input): void
    {
        $writer = new CallbackWriter($handle);

        $this->assertInstanceOf(CallbackWriter::class, $writer);
        $writer($input);
    }

    /**
     * @return callable[][]|array[][]
     */
    public function writerProvider(): array
    {
        return [
            [$this->createHandle([]), []],
            [$this->createHandle(['foo']), ['foo']],
            [$this->createHandle(['foo', 'bar', 'baz']), ['foo', 'bar', 'baz']]
        ];
    }

    /**
     * @param iterable $expected
     *
     * @return callable
     */
    private function createHandle(iterable $expected): callable
    {
        return function (iterable $input) use ($expected) : void {
            $this->assertEquals($expected, $input);
        };
    }
}
