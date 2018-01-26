<?php
namespace ZeroConfig\Cli;

use Generator;

/**
 * Get the data piped to the current application.
 *
 * @return Generator
 * @yield  string
 */
function pipe(): Generator
{
    if (ftell(STDIN) !== false) {
        do {
            yield fgets(STDIN);
        } while (!feof(STDIN));
    }
}
