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
        __DIR__ . '/../vendor/autoload.php'
    ],
    function (?string $carry, string $file): ?string {
        return realpath($file) ?: $carry;
    },
    realpath(__DIR__ . '/../../../autoload.php') ?: null
);
