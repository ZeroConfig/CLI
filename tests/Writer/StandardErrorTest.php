<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Writer\StandardError;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\StandardError
 */
class StandardErrorTest extends TestCase
{
    /**
     * @return void
     * @covers ::getHandle
     */
    public function testGetHandle(): void
    {
        $writer = new StandardError();
        $this->assertInternalType('resource', $writer->getHandle());
    }
}
