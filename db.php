<?php

$env = parse_ini_file('.env');

$DB_USER = $env['DB_USER'];
$DB_PASS = $env['DB_PASS'];

define('DB_HOST', '127.0.0.1');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_NAME', $DB_USER);
define('DB_PORT', 3307);

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}