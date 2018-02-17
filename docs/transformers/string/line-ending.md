# Line endings

Data coming in may differ in structure from data going out.
When data coming in is not a set of lines ending in an end of line character
sequence, it may yield unexpected results to then store this data in a file.

The following shows how data is concatenated on the same line:

```php
<?php
use ZeroConfig\Cli\Writer\File;

$input  = ['foo', 'bar', 'baz'];
$writer = new File('output.txt');

// Write the input to file.
$writer($input);
```

In `output.txt`, the following is written:

```
foobarbaz
```

By adding the line ending filter, output will be split up. The default value for
line endings is `PHP_EOL`.

```php
<?php
use ZeroConfig\Cli\Writer\File;
use ZeroConfig\Cli\Transformer\String\LineEnding;

$input  = ['foo', 'bar', 'baz'];
$writer = new File('output.txt');
$filter = new LineEnding();

// Write the input to file.
$writer($filter($input));
```

In `output.txt`, the following is written:

```
foo
bar
baz
```

While this is a convenient default, the line ending can also be used to separate
using other character sequences:

```php
<?php
use ZeroConfig\Cli\Writer\File;
use ZeroConfig\Cli\Transformer\String\LineEnding;

$input  = ['foo', 'bar', 'baz'];
$writer = new File('output.txt');
$filter = new LineEnding(':');

// Write the input to file.
$writer($filter($input));
```

In `output.txt`, the following is written:

```
foo:bar:baz:
```

# Further reading

See other available [transformers](../../transformers.md).
