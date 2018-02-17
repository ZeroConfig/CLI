# Handling database operations

To support database operations, one can use the callback family of
[input](../input/callback.md), [output](../output/callback.md) and
[transformer](../transformers/callback/callback.md).

Let's say there is a scenario where memory is scarce, yet database records
containing relatively large fields need to be updated. For all intents and
purposes, this cannot be handled by offloading a query to the database server.

The following shows a quick example of how to manipulate and update records in
the database, using modular components. This example blatantly ignores that the
shown operation could have been done using a single database query.

```php
<?php
use ZeroConfig\Cli\Reader\CallbackResource;
use ZeroConfig\Cli\Transformer\Callback\CallbackTransformer;
use ZeroConfig\Cli\Writer\CallbackWriter;

/**
 * @var PDO $connection The connection to the database server.
 */

// Get the content of all records from the pages table.
$reader = new CallbackResource(
    function () use ($connection) : iterable {
        $pages = $connection->query(
            'SELECT id, content FROM pages',
            PDO::FETCH_ASSOC
        );
        
        foreach ($pages ?: [] as $page) {
            yield $page;
        }
    }
);

// Update instances of the old company address to the new address.
// Only yield affected pages.
$patcher = new CallbackTransformer(
    function (iterable $pages) : iterable {
        $pattern     = '#old street 1337#ig';
        $replacement = '42 New street';
        
        foreach ($pages as $page) {
            if (!preg_match($pattern, $page['content'] ?? '')) {
                continue;
            }
            
            yield [
                ':id' => $page['id'],
                ':content' => preg_replace(
                    $pattern,
                    $replacement,
                    $page['content']
                )
            ];
        }
    }
);

// Update all affected pages.
$writer = new CallbackWriter(
    function (iterable $pages) use ($connection) : void {
        $numUpdated = 0;
        $update     = $connection->prepare(
            'UPDATE pages SET content = :content WHERE id = :id'
        );
                
        foreach ($pages as $page) {
            if (!$update->execute($page)) {
                [$state, $code, $message] = $connection->errorInfo();
                
                echo sprintf('%s: %s', $state, $message) . PHP_EOL;
                exit($code);
            }
            
            $numUpdated++;
        }
        
        echo sprintf('Updated %d records', $numUpdated) . PHP_EOL;
    }
);

// Read -> patch -> write.
$writer($patcher($reader));

// Close the connection.
unset($connection);
```

When executing the code, the following will happen:

1. A page is fetched from the database
2. The page is matched and optionally patched; otherwise repeat from step 1
3. If the page is patched, it will be written to the database
4. If the page was successfully written, repeat from step 1 until no more pages
   are fetched; otherwise exit with an error code

When everything went as planned, it outputs the number of updated records.

Keep in mind the order in which things happen. Because everything works with
[generators](https://secure.php.net/manual/en/language.generators.overview.php), 
the `$connection->prepare('UPDATE ...);` happens before
`$connection->query('SELECT ...');` does.

## Limit number of patches per run

If one wants to prevent the process above from running too long, the process can
be halted after _n_ number of effective patches, like so:

```php
<?php
use ZeroConfig\Cli\Reader\ReaderInterface;
use ZeroConfig\Cli\Transformer\TransformerInterface;
use ZeroConfig\Cli\Writer\WriterInterface;
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\Sequence\LimitFilter;

/**
 * @var PDO                  $connection
 * @var ReaderInterface      $reader
 * @var TransformerInterface $patcher
 * @var WriterInterface      $writer
 */

$transformer = new TransformerChain(
    $patcher,
    // Break the chain after 500 patches have been applied.
    new LimitFilter(500)
);

// Read -> patch -> write
$writer($transformer($reader));

// Close the connection.
unset($connection);
```

When doing this, it is suggested to update the initial select query, so it sorts
by a field like `updated_at` in ascending direction. Simply repeat the process
until it outputs:

```
Updated 0 records
```

# Further reading

See the [PDO manual](https://secure.php.net/manual/en/book.pdo.php) for more on
setting up a PDO connection.
