# Output

Opposite the [input sources](input.md), there are output writers.
One for `STDOUT` and one for `STDERR`, as well as one dedicated to write to files.

Output writers expect iterable data and are able to write data line by line;
ideal for handling streaming data.

To implement a custom output writer, the following interfaces and classes are of
help:

| Symbol                                                 | Description                                 |
|:-------------------------------------------------------|:--------------------------------------------|
| interface `ZeroConfig\Cli\Writer\WriterInterface`      | To write iterable data.                     |
| interface `ZeroConfig\Cli\Writer\DestinationInterface` | Holds a resource handle for writers.        |
| abstract class `ZeroConfig\Cli\Writer\AbstractWriter`  | Create a writer based on a resource handle. |

## STDOUT / STDERR

To write to `STDOUT` or `STDERR`, simply choose the correct writer.

```php
<?php
use ZeroConfig\Cli\Writer\StandardOut;
use ZeroConfig\Cli\Writer\StandardError;
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Reader\File;

$input  = new StandardIn();
$writer = new StandardOut();

// Write STDIN to STDOUT.
$writer($input);

// Write a list of messages to STDOUT.
$writer(['Hello world!' . PHP_EOL]);

$input  = new File('path/to/file');
$writer = new StandardError();

// Write file to STDERR.
$writer($input);

// Write a list of errors to STDERR.
$writer(['Something unexpected happened!' . PHP_EOL]);
```

## File

To write output to a file, simply choose a file to write to.

```php
<?php
use ZeroConfig\Cli\Reader\File as InputFile;
use ZeroConfig\Cli\Writer\File as OutputFile;

$input  = new InputFile('file.src');
$output = new OutputFile('file.dst');

// Stream the input file to the output file.
$output($input);
```

To store piped data in a file, simply use `STDIN` as source:

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Writer\File;

$input  = new StandardIn();
$output = new File('output.txt');

// Stream STDIN to the output file.
$output($input);
```

# Further reading

- [Data input resources](input.md)
- [Transforming data](transformers.md)
- [Downloading large files](downloading-large-files.md)
- [Assembling a CLI tool](example-application.md)
