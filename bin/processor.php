<?php
namespace ZeroConfig\Cli;

use Generator;
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Transformer\TransformerInterface;

require_once __DIR__ . '/autoload.php';

/**
 * @param TransformerInterface $filter
 * @param string[]             ...$files
 *
 * @return Generator
 */
return function (TransformerInterface $filter, string ...$files): Generator {
    $format = count($files) < 2
        ? '%s'
        : "%2\$s:\t%1\$s";

    if (empty($files)) {
        $files[] = '-';
    }

    foreach (array_unique($files) as $file) {
        $source = $file === '-'
            ? new StandardIn()
            : new File($file);

        foreach ($filter($source) as $line) {
            yield sprintf(
                $format,
                $line,
                $file === '-'
                    ? '(standard input)'
                    : $file
            );
        }
    }
};
