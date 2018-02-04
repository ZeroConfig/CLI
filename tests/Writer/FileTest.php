<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Tests\Writer;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use ZeroConfig\Cli\Writer\File;

/**
 * @coversDefaultClass \ZeroConfig\Cli\Writer\File
 */
class FileTest extends TestCase
{
    /**
     * @dataProvider fileProvider
     *
     * @param string $file
     * @param string $mode
     *
     * @return void
     * @covers ::__construct
     * @covers ::getHandle
     */
    public function testFile(string $file, string $mode): void
    {
        $root = vfsStream::setup(
            sha1(__METHOD__),
            null,
            [$file => '']
        );

        $writer = new File($root->getChild($file)->url(), $mode);

        $this->assertInstanceOf(File::class, $writer);
        $this->assertInternalType('resource', $writer->getHandle());
    }

    /**
     * @return string[][]
     */
    public function fileProvider(): array
    {
        // @see https://secure.php.net/manual/en/function.fopen.php
        // x, x+ and e are explicitly left out as they make the test case complex
        // beyond what is required to test the unit properly.
        static $modes = ['r', 'r+', 'w', 'w+', 'a', 'a+', 'c', 'c+'];

        return array_map(
            function (string $mode) : array {
                return [
                    sprintf('%s.txt', sha1($mode)),
                    $mode
                ];
            },
            $modes
        );
    }
}
