<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Transformer\Callback;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Transformer\Callback\CallbackTransformer;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Transformer\Callback\CallbackTransformer
 */
class CallbackTransformerTest extends TestCase
{
    /**
     * @dataProvider transformerProvider
     *
     * @param callable $handle
     * @param array    $input
     * @param array    $expected
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testTransformer(
        callable $handle,
        array $input,
        array $expected
    ): void {
        $transformer = new CallbackTransformer($handle);

        $this->assertInstanceOf(CallbackTransformer::class, $transformer);

        /** @noinspection PhpParamsInspection */
        $this->assertEquals(
            $expected,
            iterator_to_array($transformer($input))
        );
    }

    /**
     * @return callable[][]|string[][][]
     */
    public function transformerProvider(): array
    {
        $handle = function (array $input) : iterable {
            foreach (array_reverse($input) as $output) {
                yield $output;
            }
        };

        return [
            [$handle, [], []],
            [$handle, ['foo'], ['foo']],
            [$handle, ['foo', 'bar'], ['bar', 'foo']],
            [$handle, ['foo', 'bar', 'baz'], ['baz', 'bar', 'foo']]
        ];
    }
}
