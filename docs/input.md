# Input

There are multiple distinct forms of input implemented. One is to read files.
It is complemented by a resource specialized in streaming Gzip encoded files.
Another is specialized in reading `STDIN`. Lastly, one is specialized in
streaming HTTP resources.

Input sources are implemented as generators and can thus be used to stream data
line by line.

# Resources

The following input resources are available:

- [File](input/file.md): read files from the local filesystem.
- [Gzip](input/gzip.md): read Gzip archives, like backups of databases or logs.
- [STDIN](input/stdin.md): read piped data streams.
- [HTTP](input/http.md): stream web resources.
- [Callback](input/callback.md): stream data using a callback.

# Custom resource

To write a custom resource, the following interfaces and classes are of help:

| Symbol                                                | Description                              |
|:------------------------------------------------------|:-----------------------------------------|
| interface `ZeroConfig\Cli\Reader\ReaderInterface`     | To function as iterator for source data. |
| interface `ZeroConfig\Cli\Reader\SourceInterface`     | To function as factory for iterators.    |
| abstract class `ZeroConfig\Cli\Reader\AbstractReader` | To implement a reader based on a source  |

# Further reading

- [Transforming data](transformers.md)
- [Outputting data](output.md)
- [Assembling a CLI tool](guides/example-application.md)
