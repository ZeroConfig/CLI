# CSV parser

The CSV parser can be used to transform single lines into arrays or even
associative arrays.

For the following examples, assume the contents of `feed.csv` as as follows:

```
foo,bar,baz
Foo,Bar,"Baz"
```

# Default parsing

```php
<?php
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Transformer\Csv\CsvParser;

$reader = new File('feed.csv');
$parser = new CsvParser();

foreach ($parser($reader) as $row) {
    var_dump($row);
}
```

Outputs:

```
array(3) {
  [0] =>
  string(3) "foo"
  [1] =>
  string(3) "bar"
  [2] =>
  string(3) "baz"
}
array(3) {
  [0] =>
  string(3) "Foo"
  [1] =>
  string(3) "Bar"
  [2] =>
  string(3) "Baz"
}
```

# Using the first line as header

```php
<?php
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Transformer\Csv\CsvParser;

$reader = new File('feed.csv');
$parser = new CsvParser();

$parser->setFirstLineIsHeader(true);

foreach ($parser($reader) as $row) {
    var_dump($row);
}
```

Outputs:

```
array(3) {
  'foo' =>
  string(3) "Foo"
  'bar' =>
  string(3) "Bar"
  'baz' =>
  string(3) "Baz"
}
```

# Define a custom header

```php
<?php
use ZeroConfig\Cli\Reader\File;
use ZeroConfig\Cli\Transformer\Csv\CsvParser;

$reader = new File('feed.csv');
$parser = new CsvParser();

$parser->setHeader(['first', 'second', 'third']);

foreach ($parser($reader) as $row) {
    var_dump($row);
}
```

Outputs:

```
array(3) {
  'first' =>
  string(3) "foo"
  'second' =>
  string(3) "bar"
  'third' =>
  string(3) "baz"
}
array(3) {
  'first' =>
  string(3) "Foo"
  'second' =>
  string(3) "Bar"
  'third' =>
  string(3) "Baz"
}
```

To remove the custom header, simply pass `null` to the corresponding setter.

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
use ZeroConfig\Cli\Transformer\Csv\CsvParser;

$parser = new CsvParser();
$parser->setDelimiter("\t");
$parser->setEnclosure("'");
$parser->setEscape('|');
```

# Further reading

See other available [transformers](../../transformers.md).
