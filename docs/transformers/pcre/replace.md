# PCRE replace filter

The following is an example of the replace filter.
It makes use of [PCRE patterns](https://secure.php.net/manual/en/book.pcre.php).

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

# Further reading

See other available [transformers](../../transformers.md).
