# File writer

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

See other [output writers](../output.md).
