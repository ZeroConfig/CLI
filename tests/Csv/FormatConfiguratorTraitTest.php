<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Csv;

use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Csv\FormatConfiguratorTrait;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Csv\FormatConfiguratorTrait
 */
class FormatConfiguratorTraitTest extends TestCase
{
    /**
     * @return void
     * @covers ::setDelimiter
     */
    public function testSetDelimiter(): void
    {
        $configurator = new class {
            use FormatConfiguratorTrait;

            /**
             * @return string
             */
            public function getDelimiter(): string
            {
                return $this->delimiter;
            }
        };

        $configurator->setDelimiter('foo');
        $this->assertEquals('foo', $configurator->getDelimiter());
    }

    /**
     * @return void
     * @covers ::setEnclosure
     */
    public function testSetEnclosure(): void
    {
        $configurator = new class {
            use FormatConfiguratorTrait;

            /**
             * @return string
             */
            public function getEnclosure(): string
            {
                return $this->enclosure;
            }
        };

        $configurator->setEnclosure('foo');
        $this->assertEquals('foo', $configurator->getEnclosure());
    }

    /**
     * @return void
     * @covers ::setEscape
     */
    public function testSetEscape(): void
    {
        $configurator = new class {
            use FormatConfiguratorTrait;

            /**
             * @return string
             */
            public function getEscape(): string
            {
                return $this->escape;
            }
        };

        $configurator->setEscape('foo');
        $this->assertEquals('foo', $configurator->getEscape());
    }
}
