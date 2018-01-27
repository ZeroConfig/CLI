<?php
namespace ZeroConfig\Cli;

use Generator;
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Reader\Pipe;
use ZeroConfig\Cli\Transformer\TransformerInterface;

require_once __DIR__ . '/autoload.php';

/**
 * @param TransformerInterface $filter
 * @param string[]             ...$files
 *
 * @return Generator
 */
return function (TransformerInterface $filter, string ...$files): Generator {
    if (count($files) < 2) {
        $input = isset($files[0])
            ? new File($files[0])
            : new Pipe();

        foreach ($filter($input) as $line) {
            yield $line;
        }

        return;
    }

    foreach ($files as $file) {
        foreach ($filter(new File($file)) as $line) {
            yield sprintf("%s:\t%s", $file, $line);
        }
    }
};
