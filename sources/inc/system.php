<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
$company = "Agro Fresh";

//USER TYPE CONSTANTS
defined('STAFF') || define('STAFF', 0);
defined('ADMIN') || define('ADMIN', 1);
defined('USER') || define('USER', 2);

/** Debug Function
 * @param mixed ...$var
 */
function d(...$var)
{
    echo "<pre>";
    var_dump(...$var);
    echo "</pre>";
}


/**
 * print (-) if variable is not set
 * used for clean output
 * @param $variable
 * @return string
 */
function db(&$variable)
{
    if (isset($variable))
        return $variable;

    else
        return '-';
}