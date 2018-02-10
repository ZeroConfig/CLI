# Assembling a CLI tool

Using the [components described so far](../README.md), let's assume we want a
tool to filter data streams with a list of patterns we can supply as arguments.

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

# Further reading

- [Predefined constants](constants.md)
- [Data input resources](input.md)
- [Transforming data](transformers.md)
- [Outputting data](output.md)
- [Downloading large files](downloading-large-files.md)
