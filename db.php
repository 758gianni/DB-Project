<?php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'u66');
define('DB_PASS', 'Kitchen.Orderly.Write.Shake.35');
define('DB_NAME', 'u66');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3307);
    
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}