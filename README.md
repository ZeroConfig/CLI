# Introduction

ZeroConfig CLI is a set of CLI tools, written in PHP, that require zero
configuration in order to function.

[![codecov](https://codecov.io/bb/zeroconfig/cli/branch/master/graph/badge.svg)](https://codecov.io/bb/zeroconfig/cli)
[![Packagist](https://img.shields.io/packagist/v/zero-config/cli.svg)](https://packagist.org/packages/zero-config/cli)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/zero-config/cli.svg)](https://secure.php.net/)
[![Packagist](https://img.shields.io/packagist/l/zero-config/cli.svg)](https://github.com/ZeroConfig/CLI/blob/master/LICENSE)
[![Phar](https://img.shields.io/badge/Phar-download-brightgreen.svg)](https://bitbucket.org/zeroconfig/cli/downloads/zc.phar)

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

# I/O

The I/O is easily handled by the [input](docs/input.md) and [output](docs/output.md)
components of the package.

## Input

Input sources are implemented as generators and can thus be used to stream data
line by line.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;

$pipe = new StandardIn();

// Echo what is piped to the application.
foreach ($pipe as $line) {
    echo $line;
}
```

| Resource                      | Description                                            |
|:------------------------------|:-------------------------------------------------------|
| [File](input/file.md)         | Read files from the local filesystem.                  |
| [Gzip](input/gzip.md)         | Read Gzip archives, like backups of databases or logs. |
| [STDIN](input/stdin.md)       | Read piped data streams.                               |
| [HTTP](input/http.md)         | Stream web resources.                                  |
| [Callback](input/callback.md) | Stream data using a callback.                          |

## Output

Output writers expect iterable data and are able to write data line by line;
ideal for handling streaming data.

```php
<?php
use ZeroConfig\Cli\Writer\File;
use ZeroConfig\Cli\Reader\ReaderInterface;

$writer = new File('The.Zookeeper\'s.Wife.mp4');

/** @var ReaderInterface $movie */
$writer($movie);
```

| Writer                                     | Description                              |
|:-------------------------------------------|:-----------------------------------------|
| [File](output/file.md)                     | Write to a file on the local filesystem. |
| [STDOUT / STDERR](output/stdout-stderr.md) | Write to the console.                    |
| [Callback](output/callback.md)             | Write to a callable handle.              |
| [CSV](output/csv.md)                       | Write to CSV files.                      |

# Transformers

[Transformers](docs/transformers.md) can be used to reduce, modify or enrich the
data between [input](docs/input.md) and [output](docs/output.md).

The following is an example of the match filter.
It makes use of [PCRE patterns](https://secure.php.net/manual/en/book.pcre.php).

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

The following are available transformers.

| Group    | Transformer                                                   | Description                                          |
|:---------|:--------------------------------------------------------------|:-----------------------------------------------------|
| Sequence | [SkipFilter](docs/transformers/sequence/skip.md)              | Skip a set number of records.                        |
| Sequence | [LimitFilter](docs/transformers/sequence/limit.md)            | Limit the number of records to a set amount.         |
| String   | [ContainsFilter](docs/transformers/string/contains.md)        | Match input that contains a substring.               |
| String   | [LineEnding](docs/transformers/string/line-ending.md)         | End strings with newlines or configurable sequences. |
| PCRE     | [MatchFilter](docs/transformers/pcre/match.md)                | Input must match a given PCRE pattern.               |
| PCRE     | [ReplaceFilter](docs/transformers/pcre/replace.md)            | Replace input using a PCRE pattern.                  |
| CSV      | [CsvParser](docs/transformers/csv/parser.md)                  | Parse CSV strings into (associative) arrays.         |
| Callback | [CallbackTransformer](docs/transformers/callback/callback.md) | Create a custom transformer using a callback.        |

## Chaining transformers

While transformers can be chained by wrapping one transformer into the other,
a convenience transformer chain is available to easily
[chain transformers](docs/guides/chaining-transformers.md).

# Guides

- [Assembling a CLI tool](docs/guides/example-application.md)
- [Downloading large files](docs/guides/downloading-large-files.md)
- [Chaining transformers](docs/guides/chaining-transformers.md)
- [Handling database operations](docs/guides/database-operations.md)
- [Mapping hosts and IP addresses](docs/guides/mapping-hosts-and-ip-addresses.md)

# General documentation

- [How to use `zc.phar`](docs/zc-usage.md)
- [Predefined constants](docs/constants.md)
