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

# Components

| Component                            | Implementations                                                                                                                                                                                                                                                                                                                                                        |
|:-------------------------------------|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Input resources](docs/input.md)     | [File](docs/input/file.md), [Gzip](docs/input/gzip.md), [STDIN](docs/input/stdin.md), [HTTP](docs/input/http.md), [Callback](docs/input/callback.md)                                                                                                                                                                                                                   |
| [Transformers](docs/transformers.md) | Sequence: [skip](docs/transformers/sequence/skip.md), [limit](docs/transformers/sequence/limit.md); String: [contains](docs/transformers/string/contains.md), [line ending](docs/transformers/string/line-ending.md); PCRE: [match](docs/transformers/pcre/match.md), [replace](docs/transformers/pcre/replace.md); [Callback](docs/transformers/callback/callback.md) |
| [Output writers](docs/output.md)     | [File](docs/output/file.md), [STDOUT](docs/output/stdout-stderr.md), [STDERR](docs/output/stdout-stderr.md), [Callback](docs/output/callback.md)                                                                                                                                                                                                                       |

# Guides

- [Assembling a CLI tool](docs/guides/example-application.md)
- [Downloading large files](docs/guides/downloading-large-files.md)
- [Chaining transformers](docs/guides/chaining-transformers.md)
- [Handling database operations](docs/guides/database-operations.md)
- [Mapping hosts and IP addresses](docs/guides/mapping-hosts-and-ip-addresses.md)

# General documentation

- [How to use `zc.phar`](docs/zc-usage.md)
- [Predefined constants](docs/constants.md)
