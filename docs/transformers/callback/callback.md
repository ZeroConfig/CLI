# Callback transformer

The callback transformer helps quickly set up transformers for data streams that
have no generic implementation.

```php
<?php
use ZeroConfig\Cli\Transformer\Callback\CallbackTransformer;
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\String\LineEnding;
use ZeroConfig\Cli\Writer\File;

$doubler = new CallbackTransformer(
    function (iterable $prices) : iterable {
        foreach ($prices as $price) {
            yield sprintf('%.2f', $price * 2);
        }
    }
);

$writer = new File('price-feed.txt');

$transformer = new TransformerChain(
    $doubler,
    new LineEnding()
);

$prices = ['12.34', '56.00'];

$writer($transformer($prices));
```

The contents of `price-feed.txt` will be:

```
24.68
112.00
```

# Further reading

See other available [transformers](../../transformers.md).
