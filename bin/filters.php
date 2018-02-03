<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

require_once __DIR__ . '/autoload.php';

use ZeroConfig\Cli\Transformer\Pcre\MatchFilter;
use ZeroConfig\Cli\Transformer\Pcre\ReplaceFilter;
use ZeroConfig\Cli\Transformer\String\ContainsFilter;
use ZeroConfig\Cli\Transformer\TransformerChain;
use ZeroConfig\Cli\Transformer\TransformerDefinition;
use ZeroConfig\Cli\Transformer\TransformerInterface;

$script = SCRIPT;

return [
    'string:contains' => new TransformerDefinition(
        function (string $pattern = ''): TransformerInterface {
            return new ContainsFilter($pattern);
        },
        <<<USAGE
Usage: $script FILTER PATTERN [FILE]...

PATTERN is an exact match for the selected lines.
    
Example: $script string:contains 'hello world' menu.h main.c
Example: cat menu.h | $script string:contains 'hello world'
USAGE
    ),
    'pcre:match' => new TransformerDefinition(
        function (string $pattern = ''): TransformerInterface {
            return new MatchFilter($pattern);
        },
        <<<USAGE
Usage: $script FILTER PATTERN [FILE]...

PATTERN is written in PCRE format.
See https://secure.php.net/manual/en/book.pcre.php

Example: $script pcre:match '/[Hh]ello world/' menu.h main.c
Example: cat menu.h | $script pcre:match '/[Hh]ello world/'
USAGE
    ),
    'pcre:replace' => new TransformerDefinition(
        function (
            string $pattern = '',
            string $replacement = ''
        ): TransformerInterface {
            return new ReplaceFilter($pattern, $replacement);
        },
        <<<USAGE
Usage: $script FILTER PATTERN REPLACEMENT [FILE]...

PATTERN is written in PCRE format.
See https://secure.php.net/manual/en/book.pcre.php

Example: $script pcre:replace '/[Hh]ello world/' 'Hello world' menu.h main.c
Example: cat menu.h | $script pcre:replace '/[Hh]ello world/' 'Hello world'
USAGE
    ),
    'pcre:match+replace' => new TransformerDefinition(
        function (
            string $pattern = '',
            string $replacement = ''
        ): TransformerInterface {
            return new TransformerChain(
                new MatchFilter($pattern),
                new ReplaceFilter($pattern, $replacement)
            );
        },
        <<<USAGE
Usage: $script FILTER PATTERN REPLACEMENT [FILE]...

PATTERN is written in PCRE format.
See https://secure.php.net/manual/en/book.pcre.php

Example: $script pcre:match+replace '/[Hh]ello world/' 'Hello world' menu.h main.c
Example: cat menu.h | $script pcre:match+replace '/[Hh]ello world/' 'Hello world'
USAGE
    )
];
