<?php
// Oracle database connection parameters
$hostname = 'DB_HOSTNAME';
$port = 'DB_PORT';
$service_name = 'SERVICE_NAME';
$username = 'DB_USERNAME';
$password = 'DB_PASSWORD';

// Establish database connection
$connection = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=$hostname)(PORT=$port)))(CONNECT_DATA=(SERVICE_NAME=$service_name)))");

// Check connection
if (!$connection) {
    $error = oci_error();
    die("Database connection error: " . $error['message']);
}
?>
