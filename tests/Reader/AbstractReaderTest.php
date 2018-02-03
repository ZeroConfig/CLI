<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Reader;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Cli\Reader\AbstractReader;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Reader\AbstractReader
 */
class AbstractReaderTest extends TestCase
{
    /**
     * @return void
     * @covers ::getIterator
     * @covers ::current
     * @covers ::rewind
     * @covers ::key
     * @covers ::valid
     * @covers ::next
     */
    public function testIterator(): void
    {
        /** @var AbstractReader|PHPUnit_Framework_MockObject_MockObject $reader */
        $reader = $this->getMockForAbstractClass(AbstractReader::class);

        $reader
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->willReturn(
                new ArrayIterator(['foo', 'bar', 'baz']),
                new ArrayIterator(['qux']),
                new ArrayIterator([])
            );

        $numLines = 0;
        foreach ($reader as $lineNumber => $line) {
            $this->assertInternalType('integer', $lineNumber);
            $this->assertInternalType('string', $line);
            $numLines++;
        }

        $this->assertEquals(3, $numLines);

        $numLines = 0;
        foreach ($reader as $lineNumber => $line) {
            $this->assertInternalType('integer', $lineNumber);
            $this->assertInternalType('string', $line);
            $numLines++;
        }

        $this->assertEquals(1, $numLines);

        $numLines = 0;
        foreach ($reader as $lineNumber => $line) {
            $this->assertInternalType('integer', $lineNumber);
            $this->assertInternalType('string', $line);
            $numLines++;
        }

        $this->assertEquals(0, $numLines);
    }
}
