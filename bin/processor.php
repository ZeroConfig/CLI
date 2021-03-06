<?php
namespace ZeroConfig\Cli;

use Generator;
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Reader\GzipResource;
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
        if ($file === '-') {
            $source = new StandardIn();
        } else {
            $source = mime_content_type($file) === 'application/x-gzip'
                ? new GzipResource($file)
                : new File($file);
        }

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
