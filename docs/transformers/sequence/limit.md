# Limiting records

To limit the number of records being processed, the limit filter can be used.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Transformer\Sequence\LimitFilter;
use ZeroConfig\Cli\Writer\File;

$input  = new StandardIn();
$output = new File('top-2000.csv');
$filter = new LimitFilter(2000);

$output($filter($input));
```

# Further reading

See other available [transformers](../../transformers.md).
