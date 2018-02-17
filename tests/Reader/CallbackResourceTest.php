<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Reader;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Reader\CallbackResource;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Reader\CallbackResource
 */
class CallbackResourceTest extends TestCase
{
    /**
     * @dataProvider resourceProvider
     *
     * @param callable $handle
     * @param array    $expected
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testResource(callable $handle, array $expected): void
    {
        $reader = new CallbackResource($handle);

        $this->assertInstanceOf(CallbackResource::class, $reader);
        $this->assertEquals($expected, iterator_to_array($reader));
    }

    /**
     * @return array[][]|callable[][]
     */
    public function resourceProvider(): array
    {
        return [
            [
                $this->createHandle([]),
                []
            ],
            [
                $this->createHandle(['foo']),
                ['foo']
            ],
            [
                $this->createHandle(['foo', 'bar', 'baz']),
                ['foo', 'bar', 'baz']
            ]
        ];
    }

    /**
     * @param array $resource
     *
     * @return callable
     */
    private function createHandle(array $resource): callable
    {
        return function () use ($resource) : iterable {
            foreach ($resource as $entry) {
                yield $entry;
            }
        };
    }
}
