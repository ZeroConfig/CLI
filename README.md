# Introduction

ZeroConfig CLI is a set of CLI tools, written in PHP, that require zero
configuration in order to function.

[![codecov](https://codecov.io/bb/zeroconfig/cli/branch/master/graph/badge.svg)](https://codecov.io/bb/zeroconfig/cli)

This package aims to provide a set of convenience methods to create CLI tooling
without having to set up a framework or having in-depth knowledge of the inner
workings of PHP CLI.

By design, it solves how to deal with large data streams. It is based on data
going in, data being manipulated and then data going out. Whether the source is
piped data, a local file or HTTP resource, it will be streamed line by line.

Transformation of data also occurs line by line, going in and coming out. The
same goes for output, whether it's written to a file or `STDOUT`.

If an application is assembled using components from this library, your
application will hold only one line of resource data in memory, at any given
moment. This WILL reduce memory consumption and is a sure fire way to keep
performance high in most CLI solutions.

# Installation

To install the code base on which the tools are built, as a library:

```
composer require zero-config/cli
```

Alternatively, a built executable can be downloaded as 
[zc.phar](https://bitbucket.org/zeroconfig/cli/downloads/zc.phar).

Correct execution rights and put it somewhere in your path:

```
chmod +x zc.phar
sudo ln -s /path/to/zc.phar /usr/bin/zc 
```

# Usage

Following is the usage description for `zc.phar`.
This section is followed by component documentation.

```
Usage: zc.phar FILTER [ARGUMENT]... [FILE]...
Search for PATTERN in each FILE.

Options:
  -V, --version            display version information and exit
      --help               display this help text and exit

Filters:
    string:contains
        Usage: zc.phar FILTER PATTERN [FILE]...
        
        PATTERN is an exact match for the selected lines.
            
        Example: zc.phar string:contains 'hello world' menu.h main.c
        Example: cat menu.h | zc.phar string:contains 'hello world'

    pcre:match
        Usage: zc.phar FILTER PATTERN [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:match '/[Hh]ello world/' menu.h main.c
        Example: cat menu.h | zc.phar pcre:match '/[Hh]ello world/'

    pcre:replace
        Usage: zc.phar FILTER PATTERN REPLACEMENT [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:replace '/[Hh]ello world/' 'Hello world' menu.h main.c
        Example: cat menu.h | zc.phar pcre:replace '/[Hh]ello world/' 'Hello world'

    pcre:match+replace
        Usage: zc.phar FILTER PATTERN REPLACEMENT [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:match+replace '/[Hh]ello world/' 'Hello world' menu.h main.c
        Example: cat menu.h | zc.phar pcre:match+replace '/[Hh]ello world/' 'Hello world'

When FILE is '-', read standard input. With fewer than 2 FILEs,
the file name is not prefixed to the output.
If FILE is a gzip encoded file, it will be decoded on-the-fly.
Exit status is 0 if any line is selected, 1 otherwise;
if any error occurs, the exit status is 2.
```

# Constants

The following constants are made available:

| Constant    | Contents                                                    |
|:------------|:------------------------------------------------------------|
| `ARGUMENTS` | Contains all CLI arguments, except for the executable path. |
| `SCRIPT`    | Contains the basename of the executable.                    | 

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

# Output

Opposite to the input sources, there are output writers. One for `STDOUT` and
one for `STDERR`, as well as one dedicated to write to files.

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

# Transformers

Transformers can be used to reduce, modify or enrich the data between input and
output.

Transformers both expect and return iterable data. Ideal for manipulating data
streams.

To write a custom transformer, implement
`ZeroConfig\Cli\Transformer\TransformerInterface`.

The optimal way to implement a transformer is by making it a generator.
This is done using the
[yield](https://secure.php.net/manual/en/language.generators.syntax.php#control-structures.yield)
keyword.

## String: contains

The contains filter is helpful in reducing the input before sending it to output.

```php
<?php
use ZeroConfig\Cli\Transformer\String\ContainsFilter;

$transformer = new ContainsFilter('bar');
$input       = [
    'This is foo!',
    'Greetings from bar :)',
    'A wonderful day from baz.'
];

foreach ($transformer($input) as $line) {
    echo $line . PHP_EOL;
}
```

The above example will output:

```
Greetings from bar :)
```

## PCRE

The following filters make use of 
[PCRE patterns](https://secure.php.net/manual/en/book.pcre.php).

### PCRE: match

The following is an example of the match filter.

```php
<?php
use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;

$transformer = new MatchFilter('/[Bb]a[rz]/');
$input       = [
    'This is foo!',
    'Greetings from bar :)',
    'A wonderful day from baz.'
];

foreach ($transformer($input) as $line) {
    echo $line . PHP_EOL;
}
```

The above example will output:

```
Greetings from bar :)
A wonderful day from baz.
```

### PCRE: replace

The following is an example of the replace filter.

```php
<?php
use ZeroConfig\Cli\Transformer\Pcre\ReplaceFilter;

$transformer = new ReplaceFilter('/b(ar|az)/', 'B$1');
$input       = [
    'This is foo!',
    'Greetings from bar :)',
    'A wonderful day from baz.'
];

foreach ($transformer($input) as $line) {
    echo $line . PHP_EOL;
}
```

The above example will output:

```
This is foo!
Greetings from Bar :)
A wonderful day from Baz.
```

## Chaining transformers

Although transformers can be chained by wrapping them in order, this may turn
into a really deep nesting fairly quickly.

To keep the chain configuration vertical, rather than horizontal, as a
convenience, a transformer chain is available.

```php
<?php
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;
use ZeroConfig\Cli\Transformer\Pcre\ReplaceFilter;

$transformer = new TransformerChain(
    new MatchFilter('/[Bb]a[rz]/'),
    new ReplaceFilter('/b(ar|az)/', 'B$1')
);
$input       = [
    'This is foo!',
    'Greetings from bar :)',
    'A wonderful day from baz.'
];

foreach ($transformer($input) as $line) {
    echo $line . PHP_EOL;
}
```

The above example will output:

```
Greetings from Bar :)
A wonderful day from Baz.
```

# Assembling a CLI tool

Using the components described so far, let's assume we want a tool to filter
data streams with a list of patterns we can supply as arguments.

```php
#!/usr/bin/env php
<?php
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Writer\StandardOut;
use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\TransformerInterface;

$input       = new StandardIn();
$output      = new StandardOut();
$transformer = new TransformerChain(
    ...array_map(
        function (string $pattern) : TransformerInterface {
            return new MatchFilter($pattern);
        },
        ARGUMENTS
    )
);

$output(
    $transformer(
        $input
    )
);
```

Assuming this is put in `bin/filter`, it works as follows:

```
cat composer.json | bin/filter '#"[^/]+/[^/]+":#'
```

The filter above should only return lines that match packages in the `require`
and `require-dev` section of the current composer package.

```
        "zero-config/cli": "@stable",
        "mediact/testing-suite": "@stable"
```

Because the transformer chain is used and creates a match filter for each
argument, the following will simply list all packages that have the sequence
'cli' in them:

```
cat composer.json | bin/filter '#"[^/]+/[^/]+":#' '/cli/'
```

The filter above should only return lines that match packages in the `require`
and `require-dev` section of the current composer package. Additionally, the
package must contain the sequence `cli`.

```
        "zero-config/cli": "@stable",
```

# Downloading large files

To download a file, simply use the `HttpResource` as input and `File` as output:

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
