# STDOUT and STDERR writers

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

# Further reading

See other [output writers](../output.md).
