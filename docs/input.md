# Input

There are multiple distinct forms of input implemented. One is to read files.
It is complemented by a resource specialized in streaming Gzip encoded files.
Another is specialized in reading `STDIN`. Lastly, one is specialized in
streaming HTTP resources.

Input sources are implemented as generators and can thus be used to stream data
line by line.

To write a custom source, the following interfaces and classes are of help:

| Symbol                                                | Description                              |
|:------------------------------------------------------|:-----------------------------------------|
| interface `ZeroConfig\Cli\Reader\ReaderInterface`     | To function as iterator for source data. |
| interface `ZeroConfig\Cli\Reader\SourceInterface`     | To function as factory for iterators.    |
| abstract class `ZeroConfig\Cli\Reader\AbstractReader` | To implement a reader based on a source  |

## File

An example of how to use a file as source.

```php
<?php
use ZeroConfig\Cli\Reader\File;

$file = new File('path/to/file');

// Read all lines of the given file.
foreach ($file as $line) {
    echo $line;
}
```

The file class can also be used as factory, to keep spawning file sources.
Each time the factory is called, a new file resource is opened, pointing to the
start of the file.

```php
<?php
use ZeroConfig\Cli\Reader\File;

$factory = new File('path/to/file');
$file    = $factory();

// Show a couple of lines.
foreach ($file as $lineNumber => $line) {
    echo $line;
    
    // Stop after a few lines.
    if ($lineNumber > 3) {
        break;
    }
}

// Reopen the file, pointing at the start.
$file = $factory();

// Show all lines.
foreach ($file as $lineNumber => $line) {
    echo $line;
}
```

## Gzip encoded

Large text files, like log files, are commonly stored in compressed archives.
To be able to process Gzip encoded data, the `GzipResource` is available.

```php
<?php
use ZeroConfig\Cli\Reader\GzipResource;

$archive = new GzipResource('access-log.gz');

foreach ($archive as $logEntry) {
    echo $logEntry;
}
```

Just like with the file resource, it can also be used as a factory.

## STDIN

To process data sent to `STDIN`, use the standard in source.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;

$pipe = new StandardIn();

foreach ($pipe as $line) {
    echo $line;
}
```

As a feature, the `StandardIn` class makes the input non-blocking. This is so
the program can exit without the user sending an exit signal to the standard input.

As a side-effect, the `STDIN` source is only useful when piping data to the program.

```
cat path/to/file | bin/program
```

In theory, the source for `STDIN` is a factory, much like with the file source.
However, when re-opening the standard input, it will not rewind to the first line
sent to `STDIN`. This is due to the nature of piping. However, it could be
used to make a natural break between parts of your data.

In the following example, assume an HTTP request, including headers, is processed.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;

$factory = new StandardIn();
$headers = $factory();

$contentType = 'text/plain';

foreach ($headers as $line) {
    $header = rtrim($line);
    
    // Found the end of the headers.
    if (empty($header)) {
        break;
    }
    
    [$key, $value] = explode(':', $header, 2);
    
    if (strtolower($key) === 'content-type') {
        $contentType = $value;
    }
}

/** @var Traversable $body */
$body = $factory();
$body = implode('', iterator_to_array($body));

if ($contentType === 'application/json') {
    $data = json_decode($body, true);
}
```

## HTTP resource

Creating an HTTP resource is as simple as passing a URL:

```php
<?php
use ZeroConfig\Cli\Reader\HttpResource;

$resource = new HttpResource('https://httpbin.org/get');

foreach ($resource as $line) {
    echo $line;
}
```

As with the other resources, the HTTP resource can also function as a factory
for itself. Note that it will then repeat HTTP requests, as the data is not kept
in memory.

# Further reading

- [Transforming data](transformers.md)
- [Outputting data](output.md)
- [Assembling a CLI tool](example-application.md)
