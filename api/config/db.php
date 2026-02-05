<?php
// api/config/db.php

$DB_HOST = "localhost";
$DB_USER = "apiuser";
$DB_PASS = "apipassword";
$DB_NAME = "COP4331";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error)
{
    http_response_code(500);
    echo json_encode([
        "id" => -1,
        "error" => "Database connection failed: " . $conn->connect_error
    ]);
    exit();
}
?>
