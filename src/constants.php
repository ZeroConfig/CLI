<?php
// @codeCoverageIgnore
if (!defined('ARGUMENTS')) {
    define('ARGUMENTS', array_slice($GLOBALS['argv'], 1) ?? []);
}

if (!defined('SCRIPT')) {
    define('SCRIPT', basename($_SERVER['SCRIPT_NAME']));
}
