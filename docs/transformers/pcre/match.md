# PCRE match filter

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

# Further reading

See other available [transformers](../../transformers.md).
