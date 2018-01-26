<?php
namespace ZeroConfig\Cli;

use Generator;

/**
 * Only yield the input data that matches the given pattern.
 *
 * @param iterable $input
 * @param string   $pattern
 *
 * @return Generator
 * @yield  string
 */
function grep(iterable $input, string $pattern): Generator
{
    foreach ($input as $line) {
        if (strpos($line, $pattern) !== false) {
            yield $line;
        }
    }
}
