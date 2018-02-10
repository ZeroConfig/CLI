# Transformers

Transformers can be used to reduce, modify or enrich the data between
[input](input.md) and [output](output.md).

Transformers both expect and return iterable data. Ideal for manipulating data
streams.

# Filters

The following transformers are available as filters:

## String
- [ContainsFilter](transformers/string/contains.md): match input that contains a substring.

## PCRE
See the PHP manual for [PCRE patterns](https://secure.php.net/manual/en/book.pcre.php).

- [MatchFilter](transformers/pcre/match.md): input must match a given PCRE pattern.
- [ReplaceFilter](transformers/pcre/replace.md): replace input using a PCRE pattern.

# Chaining transformers

While transformers can be chained by wrapping one transformer into the other,
a convenience transformer chain is available to easily
[chain transformers](guides/chaining-transformers.md).

# Custom transformer

To write a custom transformer, implement
`ZeroConfig\Cli\Transformer\TransformerInterface`.

The optimal way to implement a transformer is by making it a generator.
This is done using the
[yield](https://secure.php.net/manual/en/language.generators.syntax.php#control-structures.yield)
keyword.
