<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Reader;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ZeroConfig\Cli\Reader\HttpResource;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Reader\HttpResource
 */
class HttpResourceTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            HttpResource::class,
            new HttpResource('http://0.0.0.0')
        );
    }

    /**
     * @return void
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUrl(): void
    {
        new HttpResource(
            vfsStream::setup(
                sha1(__METHOD__)
            )->url()
        );
    }

    /**
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(): void
    {
        $root = vfsStream::setup(
            sha1(__METHOD__),
            null,
            [
                'feed.json' => '[]'
            ]
        );

        $reflection = new ReflectionClass(HttpResource::class);
        $resource   = $reflection->newInstanceWithoutConstructor();

        $url = $reflection->getProperty('url');
        $url->setAccessible(true);
        $url->setValue($resource, $root->getChild('feed.json')->url());
        $url->setAccessible(false);

        $artifact = $resource->__invoke();

        $this->assertTrue(is_iterable($artifact));

        foreach ($artifact as $chunk) {
            $this->assertInternalType('string', $chunk);
        }
    }
}
