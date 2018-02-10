# File resource

An example of how to use a file as source.

```php
<?php
use ZeroConfig\Cli\Reader\File;

$file = new File('path/to/file');

// Read all lines of the given file.
foreach ($file as $line) {
    echo $line;
}
```

The file class can also be used as factory, to keep spawning file sources.
Each time the factory is called, a new file resource is opened, pointing to the
start of the file.

```php
<?php
use ZeroConfig\Cli\Reader\File;

$factory = new File('path/to/file');
$file    = $factory();

// Show a couple of lines.
foreach ($file as $lineNumber => $line) {
    echo $line;
    
    // Stop after a few lines.
    if ($lineNumber > 3) {
        break;
    }
}

// Reopen the file, pointing at the start.
$file = $factory();

// Show all lines.
foreach ($file as $lineNumber => $line) {
    echo $line;
}
```

# Further reading

See other [input resources](../input.md).
