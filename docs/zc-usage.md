# Usage

Following is the usage description for `zc.phar`.

```
Usage: zc.phar FILTER [ARGUMENT]... [FILE]...
Search for PATTERN in each FILE.

Options:
  -V, --version            display version information and exit
      --help               display this help text and exit

Filters:
    string:contains
        Usage: zc.phar FILTER PATTERN [FILE]...
        
        PATTERN is an exact match for the selected lines.
            
        Example: zc.phar string:contains 'hello world' menu.h main.c
        Example: cat menu.h | zc.phar string:contains 'hello world'

    pcre:match
        Usage: zc.phar FILTER PATTERN [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:match '/[Hh]ello world/' menu.h main.c
        Example: cat menu.h | zc.phar pcre:match '/[Hh]ello world/'

    pcre:replace
        Usage: zc.phar FILTER PATTERN REPLACEMENT [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:replace '/[Hh]ello world/' 'Hello world' menu.h main.c
        Example: cat menu.h | zc.phar pcre:replace '/[Hh]ello world/' 'Hello world'

    pcre:match+replace
        Usage: zc.phar FILTER PATTERN REPLACEMENT [FILE]...
        
        PATTERN is written in PCRE format.
        See https://secure.php.net/manual/en/book.pcre.php
        
        Example: zc.phar pcre:match+replace '/[Hh]ello world/' 'Hello world' menu.h main.c
        Example: cat menu.h | zc.phar pcre:match+replace '/[Hh]ello world/' 'Hello world'

When FILE is '-', read standard input. With fewer than 2 FILEs,
the file name is not prefixed to the output.
If FILE is a gzip encoded file, it will be decoded on-the-fly.
Exit status is 0 if any line is selected, 1 otherwise;
if any error occurs, the exit status is 2.
```
