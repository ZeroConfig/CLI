# Output

Opposite the [input sources](input.md), there are output writers.
One for `STDOUT` and one for `STDERR`, as well as one dedicated to write to files.

Output writers expect iterable data and are able to write data line by line;
ideal for handling streaming data.

# Writers

- [File](output/file.md): write to a file on the local filesystem.
- [STDOUT / STDERR](output/stdout-stderr.md): write to the console.

# Custom writer

To implement a custom output writer, the following interfaces and classes are of
help:

| Symbol                                                 | Description                                 |
|:-------------------------------------------------------|:--------------------------------------------|
| interface `ZeroConfig\Cli\Writer\WriterInterface`      | To write iterable data.                     |
| interface `ZeroConfig\Cli\Writer\DestinationInterface` | Holds a resource handle for writers.        |
| abstract class `ZeroConfig\Cli\Writer\AbstractWriter`  | Create a writer based on a resource handle. |

# Further reading

- [Data input resources](input.md)
- [Transforming data](transformers.md)
- [Downloading large files](guides/downloading-large-files.md)
- [Assembling a CLI tool](guides/example-application.md)
