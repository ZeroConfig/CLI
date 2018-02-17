# Callback writer

Not all destinations for data have a predefined implementation. To create an
on-the-fly implementation for a writer, use the callback writer.

```php
<?php
use ZeroConfig\Cli\Writer\CallbackWriter;

/** @var PDO $connection */
$writer = new CallbackWriter(
    function (iterable $output) use ($connection) : void {
        $operation = $connection->prepare(
            'INSERT INTO logs (`level`, `message`) VALUES (:level, :message)'
        );
        
        foreach ($output as $message) {
            $operation->execute(
                [
                    ':level' => 'debug',
                    ':message' => $message
                ]
            );
        }
    }
);
```

# Further reading

See other [output writers](../output.md).
