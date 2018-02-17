<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Csv;

interface FormatConfiguratorInterface
{
    /**
     * Set the delimiter.
     *
     * @param string $delimiter
     *
     * @return void
     */
    public function setDelimiter(string $delimiter): void;

    /**
     * Set the enclosure for values.
     *
     * @param string $enclosure
     *
     * @return void
     */
    public function setEnclosure(string $enclosure): void;

    /**
     * Set the escape sequence.
     *
     * @param string $escape
     *
     * @return void
     */
    public function setEscape(string $escape): void;
}
