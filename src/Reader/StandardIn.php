<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Reader;

class StandardIn extends AbstractReader
{
    /**
     * Get an iterable source of data.
     *
     * @return iterable
     *
     * @codeCoverageIgnore
     */
    public function __invoke(): iterable
    {
        if (ftell(STDIN) !== false) {
            do {
                yield fgets(STDIN);
            } while (!feof(STDIN));
        }
    }
}
