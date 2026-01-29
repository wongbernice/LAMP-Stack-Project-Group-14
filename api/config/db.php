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
 */
