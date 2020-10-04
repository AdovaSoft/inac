<?php
/**
 * HTML page generation Class
 */
include "./sources/class/html.php";
/**
 * Insert Operation Class
 */
include "./sources/class/inserter.php";

/**
 * Index Data Access data Query Class
 * @extends Query Class
 */
include "./sources/class/indquery.php";

/**
 * this function convert number to money format
 * input 1000000 to 1,000,000.00
 * @param int $number
 * @return int|string
 */
function money($number = 0)
{
    if (is_numeric($number))
        return number_format($number, 2, ".", ",");
    else
        return $number;
}