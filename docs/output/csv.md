# CSV writer

To write arrays of data into CSV files, the CSV writer can be used.

```php
<?php
use ZeroConfig\Cli\Writer\CsvWriter;

$writer = new CsvWriter('feed.csv');

$writer(
    [
        ['foo', 'bar', 'baz'],
        ['one', 'two', 'three']
    ]
);
```

This makes the contents of `feed.csv` be:

```
foo,bar,baz
one,two,three
```

# Custom format

In order to support multiple formats, the delimiter, enclosure and escape
sequence can be set to a custom value.

The defaults are:

| Property  | Value |
|:----------|:------|
| Delimiter | `,`   |
| Enclosure | `"`   |
| Escape    | `\`   |

They can be updated with corresponding setters:

```php
<?php
use ZeroConfig\Cli\Writer\CsvWriter;

$writer = new CsvWriter('feed.csv');

$writer->setDelimiter(':');
$writer->setEnclosure("'");
$writer->setEscape('|');

$writer(
    [
        ['foo', 'bar', 'baz'],
        ['one', 'two', 'three']
    ]
);
```

This makes the contents of `feed.csv` be:

```
foo:bar:baz
one:two:three
```

# Further reading

See other [output writers](../output.md).
