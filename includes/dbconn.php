<?php
/* Database config */
$db_host        = 'localhost';
$db_user        = 'root';
$db_pass        = 'test';
$db_database    = 'gsdshop';
/* End config */

$con = null;
$db_connection_error = null;

if (!function_exists('mysqli_connect')) {
    $db_connection_error = 'MySQLi extension is not available in this PHP environment.';
    return;
}

mysqli_report(MYSQLI_REPORT_OFF);
$con = @mysqli_connect($db_host, $db_user, $db_pass, $db_database);

if (!$con) {
    $db_connection_error = mysqli_connect_error();
}
