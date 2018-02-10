# Skipping a number of records

When input contains a CSV header or any other table header commonly found in
process output, the skip filter may be of help.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;
use ZeroConfig\Cli\Transformer\Sequence\SkipFilter;
use ZeroConfig\Cli\Writer\File;

$input  = new StandardIn();
$output = new File('records.csv');
$filter = new SkipFilter(1);

$output($filter($input));
```

# Further reading

See other available [transformers](../../transformers.md).
