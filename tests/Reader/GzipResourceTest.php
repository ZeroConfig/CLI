<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Reader;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Reader\GzipResource;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Reader\GzipResource
 */
class GzipResourceTest extends TestCase
{
    public const ARCHIVE = __DIR__ . '/../Fixtures/.gitignore.gz';

    /**
     * @return void
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(
            GzipResource::class,
            new GzipResource(static::ARCHIVE)
        );
    }

    /**
     * @return void
     * @covers ::__invoke
     */
    public function testInvoke(): void
    {
        $file     = new GzipResource(static::ARCHIVE);
        $resource = $file->__invoke();

        $this->assertTrue(is_iterable($resource));

        foreach ($resource as $line) {
            $this->assertInternalType('string', $line);
        }
    }
}
