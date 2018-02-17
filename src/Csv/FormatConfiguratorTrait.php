<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Csv;

trait FormatConfiguratorTrait
{
    /** @var string */
    private $delimiter = ',';

    /** @var string */
    private $enclosure = '"';

    /** @var string */
    private $escape = '\\';

    /**
     * Set the delimiter.
     *
     * @param string $delimiter
     *
     * @return void
     */
    public function setDelimiter(string $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Set the enclosure for values.
     *
     * @param string $enclosure
     *
     * @return void
     */
    public function setEnclosure(string $enclosure): void
    {
        $this->enclosure = $enclosure;
    }

    /**
     * Set the escape sequence.
     *
     * @param string $escape
     *
     * @return void
     */
    public function setEscape(string $escape): void
    {
        $this->escape = $escape;
    }
}
