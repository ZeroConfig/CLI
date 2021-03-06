<?php
set_error_handler(
    function (int $severity, string $message, string $file, int $line): void {
        throw new ErrorException(
            $message,
            0,
            $severity,
            $file,
            $line
        );
    }
);

set_exception_handler(
    function (Throwable $e): void {
        fwrite(STDERR, $e->getMessage() . PHP_EOL);
        exit(2);
    }
);

/** @noinspection PhpIncludeInspection */
require_once array_reduce(
    [
        __DIR__ . '/../vendor/autoload.php',
    ],
    function (?string $carry, string $file): ?string {
        return file_exists($file)
            ? $file
            : $carry;
    },
    realpath(__DIR__ . '/../../../autoload.php') ?: null
);

if (in_array('--version', ARGUMENTS, true)
    || in_array('-V', ARGUMENTS, true)
) {
    $versionFile = __DIR__ . '/../dist/version';
    echo sprintf(
        '%s version %s',
        basename($_SERVER['SCRIPT_NAME']),
        file_exists($versionFile)
            ? trim(file_get_contents($versionFile))
            : 'source'
    ) . PHP_EOL;
    exit(0);
}
