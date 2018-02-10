# STDIN resource

To process data sent to `STDIN`, use the standard in resource.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;

$pipe = new StandardIn();

foreach ($pipe as $line) {
    echo $line;
}
```

As a feature, the `StandardIn` class makes the input non-blocking. This is so
the program can exit without the user sending an exit signal to the standard input.

As a side-effect, the `STDIN` source is only useful when piping data to the program.

```
cat path/to/file | bin/program
```

In theory, the source for `STDIN` is a factory, much like with the file source.
However, when re-opening the standard input, it will not rewind to the first line
sent to `STDIN`. This is due to the nature of piping. However, it could be
used to make a natural break between parts of your data.

In the following example, assume an HTTP request, including headers, is processed.

```php
<?php
use ZeroConfig\Cli\Reader\StandardIn;

$factory = new StandardIn();
$headers = $factory();

$contentType = 'text/plain';

foreach ($headers as $line) {
    $header = rtrim($line);
    
    // Found the end of the headers.
    if (empty($header)) {
        break;
    }
    
    [$key, $value] = explode(':', $header, 2);
    
    if (strtolower($key) === 'content-type') {
        $contentType = $value;
    }
}

/** @var Traversable $body */
$body = $factory();
$body = implode('', iterator_to_array($body));

if ($contentType === 'application/json') {
    $data = json_decode($body, true);
}
```

# Further reading

See other [input resources](../input.md).
