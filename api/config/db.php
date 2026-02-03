<?php
/**
 * FILE: api/config/db.php
 * PURPOSE:
 *   Create and expose the database connection for the API.
 *
 * WHAT IT DOES:
 *   - Connects to MySQL/MariaDB (PDO or mysqli).
 *   - Provides a connection handle (e.g., $pdo or $conn) for queries.
 *   - Should fail gracefully with a JSON error if connection cannot be made.
 *
 * USED BY:
 *   - auth/login.php, auth/register.php
 *   - contacts/add.php, contacts/search.php, contacts/edit.php, contacts/delete.php
 *
 * NOTES:
 *   - Keep credentials in one place.
 *   - Use prepared statements in all queries to prevent SQL injection.
 * 
 */
// api/config/db.php
$host = "localhost";
$user = "YOUR_DB_USER";
$pass = "YOUR_DB_PASS";
$db   = "YOUR_DB_NAME";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  // don't echo raw text; return JSON error consistently
  header("Content-Type: application/json");
  echo json_encode(["id" => -1, "error" => $conn->connect_error]);
  exit();
}
?>

