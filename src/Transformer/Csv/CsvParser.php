<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace ZeroConfig\Cli\Transformer\Csv;

use Throwable;
use ZeroConfig\Cli\Transformer\TransformerInterface;

class CsvParser implements TransformerInterface
{
    /** @var string */
    private $delimiter = ',';

    /** @var string */
    private $enclosure = '"';

    /** @var string */
    private $escape = '\\';

    /** @var string[]|null */
    private $header;

    /** @var bool */
    private $firstLineIsHeader = false;

    /**
     * Apply data transformations to the input and return an iterable result.
     *
     * @param iterable $input
     *
     * @return iterable
     */
    public function __invoke(iterable $input): iterable
    {
        $header = $this->firstLineIsHeader
            ? null
            : $this->header;

        foreach ($input as $line) {
            $row = str_getcsv(
                $line,
                $this->delimiter,
                $this->enclosure,
                $this->escape
            );

            if ($this->firstLineIsHeader && $header === null) {
                $header = $row;
                continue;
            }

            if ($header !== null) {
                try {
                    $row = array_combine($header, $row);
                } catch (Throwable $exception) {
                    continue;
                }
            }

            if (!empty($row)) {
                yield $row;
            }
        }
    }

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

    /**
     * Set the header for each row.
     * If the header is supplied, it will be used as keys for the fields in each
     * row.
     * When the header is set to null, rows get zero-indexed keys.
     *
     * @param null|string[] $header
     *
     * @return void
     */
    public function setHeader(?array $header): void
    {
        $this->header = $header;
    }

    /**
     * Tell the parser to use the first line of the stream as the header for
     * records that follow.
     *
     * @param bool $firstLineIsHeader
     *
     * @return void
     */
    public function setFirstLineIsHeader(bool $firstLineIsHeader): void
    {
        $this->firstLineIsHeader = $firstLineIsHeader;
    }
}
