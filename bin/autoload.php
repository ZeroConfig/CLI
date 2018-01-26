<?php
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
