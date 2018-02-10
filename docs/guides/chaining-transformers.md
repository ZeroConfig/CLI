# Chaining transformers

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

# Further reading

See available [transformers](../transformers.md).
