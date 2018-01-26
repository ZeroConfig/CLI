<?php
namespace ZeroConfig\Cli;

use Generator;

require_once __DIR__ . '/autoload.php';

/**
 * @param callable $filter
 * @param string[] ...$files
 *
 * @return Generator&string[]
 */
return function (callable $filter, string ...$files): Generator {
    if (count($files) < 2) {
        $input = isset($files[0])
            ? file($files[0])
            : pipe();

        foreach ($filter($input) as $line) {
            yield $line;
        }

        exit;
    }

    foreach ($files as $file) {
        foreach ($filter(file($file)) as $line) {
            yield sprintf("%s:\t%s", $file, $line);
        }
    }
};
