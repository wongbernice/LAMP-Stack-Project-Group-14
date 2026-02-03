<?php
/**
 * EXPECTED METHOD:
 *   - POST
 *
 * EXPECTED INPUT (JSON):
 *   Required:
 *     - id (contact id)
 *     - userId (owner user id)
 *   Optional (one or more):
 *     - firstName, lastName, phone, email
 *
 * OUTPUT:
 *   - Success: {"id":<contactId>, "message":"...", "error":""}
 *   - Error:   {"id":-1, "error":"..."}
 */

require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";

$inData = getRequestInfo();

// Required
$contactId = $inData["id"] ?? "";
$userId    = $inData["userId"] ?? "";

// Optional updates (only update what frontend sends)
$firstName = array_key_exists("firstName", $inData) ? trim((string)$inData["firstName"]) : null;
$lastName  = array_key_exists("lastName",  $inData) ? trim((string)$inData["lastName"])  : null;
$phone     = array_key_exists("phone",     $inData) ? trim((string)$inData["phone"])     : null;
$email     = array_key_exists("email",     $inData) ? trim((string)$inData["email"])     : null;

if ($contactId === "" || $userId === "") {
  returnWithError("Missing required fields: id, userId");
}

// Require at least one field to update
if ($firstName === null && $lastName === null && $phone === null && $email === null) {
  returnWithError("No fields provided to update");
}

/****************************************************************
 * TEMP (NO DB YET)
 ****************************************************************/
returnWithInfo("Edit endpoint wired. DB update is currently disabled.", (int)$contactId);

/****************************************************************
 * DATABASE (ENABLE LATER)
 ****************************************************************/
/*
require_once __DIR__ . "/../config/db.php";

// TODO: Confirm your schema + column names.
// Example assumption:
//   Contacts(ID, FirstName, LastName, Phone, Email, UserID)

// 1) Ensure the contact exists and belongs to this user
$check = $conn->prepare("SELECT ID FROM Contacts WHERE ID=? AND UserID=?");
if (!$check) returnWithError($conn->error);

$check->bind_param("ii", $contactId, $userId);
$check->execute();
$res = $check->get_result();
if (!$res || !$res->fetch_assoc()) {
  $check->close();
  $conn->close();
  returnWithError("Contact not found");
}
$check->close();

// 2) Build dynamic update query safely
$fields = [];
$params = [];
$types  = "";

if ($firstName !== null) { $fields[] = "FirstName=?"; $params[] = $firstName; $types .= "s"; }
if ($lastName  !== null) { $fields[] = "LastName=?";  $params[] = $lastName;  $types .= "s"; }
if ($phone     !== null) { $fields[] = "Phone=?";     $params[] = $phone;     $types .= "s"; }
if ($email     !== null) { $fields[] = "Email=?";     $params[] = $email;     $types .= "s"; }

$sql = "UPDATE Contacts SET " . implode(",", $fields) . " WHERE ID=? AND UserID=?";
$params[] = (int)$contactId; $types .= "i";
$params[] = (int)$userId;    $types .= "i";

$stmt = $conn->prepare($sql);
if (!$stmt) returnWithError($conn->error);

// Bind params dynamically
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
  returnWithInfo("Contact updated", (int)$contactId);
} else {
  returnWithError($stmt->error);
}

$stmt->close();
$conn->close();
*/
?>
