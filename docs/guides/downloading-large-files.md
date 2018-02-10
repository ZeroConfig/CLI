# Downloading large files

To download a file, simply use the `HttpResource` as [input](../input.md) and
`File` as [output](../output.md):

```php
<?php
use ZeroConfig\Cli\Reader\HttpResource;
use ZeroConfig\Cli\Writer\File;

$download = new HttpResource('https://bitbucket.org/zeroconfig/cli/downloads/zc.phar');
$writer   = new File('/usr/bin/zc');

// Download the file line by line and write each line as it comes.
$writer($download);
```

If one wants to keep track of progress, the script above can be easily expanded:

```php
<?php
use ZeroConfig\Cli\Reader\HttpResource;
use ZeroConfig\Cli\Writer\File;
use ZeroConfig\Cli\Writer\StandardOut;

$download = new HttpResource('https://bitbucket.org/zeroconfig/cli/downloads/zc.phar');
$writer   = new File('/usr/bin/zc');
$output   = new StandardOut();

foreach ($download as $chunk) {
    // Write a single chunk.
    $writer([$chunk]);
    
    // Output a dot to mark progress for the active download.
    $output(['.']);
}

$output([PHP_EOL, 'Done', PHP_EOL]);
```

# Further reading

- [Data input resources](../input.md)
- [Transforming data](../transformers.md)
- [Outputting data](../output.md)
- [Assembling a CLI tool](example-application.md)
