<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Reader;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Reader\File;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Reader\File
 */
class FileTest extends TestCase
{
    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $root = vfsStream::setup(
            sha1(__METHOD__),
            null,
            [
                'test' => 'Foo'
            ]
        );

        $this->assertInstanceOf(
            File::class,
            new File($root->getChild('test')->url())
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
                'test' => 'Foo'
            ]
        );

        $file = new File($root->getChild('test')->url());
        $this->assertTrue(
            is_iterable($file->__invoke())
        );
    }
}
