# Gzip resource

Large text files, like log files, are commonly stored in compressed archives.
To be able to process Gzip encoded data, the `GzipResource` is available.

```php
<?php
use ZeroConfig\Cli\Reader\GzipResource;

$archive = new GzipResource('access-log.gz');

foreach ($archive as $logEntry) {
    echo $logEntry;
}
```

Just like with the file resource, it can also be used as a factory.

# Further reading

See other [input resources](../input.md).
