# String contains filter

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

# Further reading

See other available [transformers](../../transformers.md).
