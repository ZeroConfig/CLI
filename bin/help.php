<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

use ZeroConfig\Cli\Transformer\TransformerDefinitionInterface;

require_once __DIR__ . '/autoload.php';

/** @var TransformerDefinitionInterface[] $filters */
$filters = require_once __DIR__ . '/filters.php';

$script       = SCRIPT;
$filterUsages = '';
$padding      = str_repeat(' ', 4);

foreach ($filters as $filter => $definition) {
    $filterUsages .= sprintf('%2$s%1$s', $filter, $padding) . PHP_EOL;

    $usage = explode(PHP_EOL, $definition->getUsageDescription());

    foreach ($usage as $line) {
        $filterUsages .= sprintf(
            '%2$s%2$s%1$s',
            $line,
            $padding
        ) . PHP_EOL;
    }

    $filterUsages .= PHP_EOL;
}

$filterUsages = rtrim($filterUsages);

return <<<USAGE
Usage: $script FILTER [ARGUMENT]... [FILE]...
Search for PATTERN in each FILE.

Options:
  -V, --version            display version information and exit
      --help               display this help text and exit

Filters:
$filterUsages

When FILE is '-', read standard input. With fewer than 2 FILEs,
the file name is not prefixed to the output.
If FILE is a gzip encoded file, it will be decoded on-the-fly.
Exit status is 0 if any line is selected, 1 otherwise;
if any error occurs, the exit status is 2.

USAGE
;
