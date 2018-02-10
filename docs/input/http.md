# HTTP resource

Creating an HTTP resource is as simple as passing a URL:

```php
<?php
use ZeroConfig\Cli\Reader\HttpResource;

$resource = new HttpResource('https://httpbin.org/get');

foreach ($resource as $line) {
    echo $line;
}
```

As with the other resources, the HTTP resource can also function as a factory
for itself. Note that it will then repeat HTTP requests, as the data is not kept
in memory.

# Further reading

See other [input resources](../input.md).
