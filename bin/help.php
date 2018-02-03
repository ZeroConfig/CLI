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

foreach ($filters as $filter => $definition) {
    $filterUsages .= sprintf('    %s', $filter) . PHP_EOL;

    $usage = explode(PHP_EOL, $definition->getUsageDescription());

    foreach ($usage as $line) {
        $filterUsages .= sprintf(
                '        %s',
                $line
            ) . PHP_EOL;
    }

    $filterUsages .= PHP_EOL;
}

$filterUsages = rtrim($filterUsages);

return <<<USAGE
Usage: $script FILTER PATTERN [FILE]...
Search for PATTERN in each FILE.

Options:
  -V, --version            display version information and exit
      --help               display this help text and exit

Filters:
$filterUsages

When FILE is '-', read standard input. With fewer than 2 FILEs,
the file name is not prefixed to the output.
Exit status is 0 if any line is selected, 1 otherwise;
if any error occurs, the exit status is 2.

USAGE
;
