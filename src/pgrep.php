<?php
namespace ZeroConfig\Cli;

use Generator;

/**
 * Only yield the input that matches the given PCRE compatible pattern.
 *
 * @param iterable $input
 * @param string   $pattern
 *
 * @return Generator
 * @yield  string
 */
function pgrep(iterable $input, string $pattern): Generator
{
    foreach ($input as $line) {
        if (preg_match($pattern, $line)) {
            yield $line;
        }
    }
}
