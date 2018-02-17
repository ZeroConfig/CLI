# Callback resource

To process data from a custom resource, using a callable.

```php
<?php
use ZeroConfig\Cli\Reader\CallbackResource;

/** @var callable $handle */
$reader = new CallbackResource($handle);

foreach ($reader as $line) {
    echo $line;
}
```

This can be useful to process data for which a generic resource is not available.
The following example shows how to use the callback reader to query a database
using [PDO](https://secure.php.net/manual/en/book.pdo.php).

```php
<?php
use ZeroConfig\Cli\Reader\CallbackResource;
use ZeroConfig\Cli\Transformer\String\LineEnding;
use ZeroConfig\Cli\Writer\File;

/** @var PDO $connection */
$reader = new CallbackResource(
    function () use ($connection) : iterable {
        // Create a statement that fetches a list of users.
        $statement = $connection->query(
            'SELECT user FROM users',
            PDO::FETCH_ASSOC
        );
        
        // If the query had no result, return an empty list.
        if ($statement === false) {
            return [];
        }

        foreach ($statement as $result) {
            // Skip rows that lack the user column.
            if (!array_key_exists('user', $result)) {
                continue;
            }
            
            // Yield the user.
            yield $result['user'];
        }
    }
);

// Store users in a text file.
$output = new File('users.txt');

// Ensure users are separated by newlines.
$filter = new LineEnding();

// Store the users in the prepared output.
$output($filter($reader));
```

# Further reading

- [Input resources](../input.md)
- [Database operations](../guides/database-operations.md)
