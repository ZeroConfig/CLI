<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Writer\StandardOut;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\StandardOut
 */
class StandardOutTest extends TestCase
{
    /**
     * @return void
     * @covers ::getHandle
     */
    public function testGetHandle(): void
    {
        $writer = new StandardOut();
        $this->assertInternalType('resource', $writer->getHandle());
    }
}
