# Transformers

Transformers can be used to reduce, modify or enrich the data between
[input](input.md) and [output](output.md).

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
