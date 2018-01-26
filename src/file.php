<?php
namespace ZeroConfig\Cli;

use Generator;
use SplFileObject;

/**
 * Open the given file as a generator.
 *
 * @param string $file
 *
 * @return Generator
 * @yield  string
 */
function file(string $file): Generator
{
    foreach (new SplFileObject($file, 'r') as $line) {
        yield $line;
    }
}
