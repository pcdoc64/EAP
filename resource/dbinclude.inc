<?php

// Google API key for EAP - AIzaSyA3UiSb7GvmU0I3_Cx5Za06EgANgVCbiQ4


error_reporting(E_ALL);
ini_set('display_errors', 1);
define('DB_HOST', 'localhost');
define('DB_NAME', 'kscouts');
define('DB_USER', 'kadmin');
define('DB_PASSWORD','Ksc0uts');
define('DBC_NAME', 'kcloud');
define('DBC_USER', 'kadmin');
define('DBC_PASSWORD','Ksc0uts');

session_start();

if (ob_get_level() == 0) ob_start();

// Base-2 logarithm of the iteration count used for password stretching
$hash_cost_log2 = 8;
// Do we require the hashes to be portable to older systems (less secure)?
$hash_portable = FALSE;

?>
