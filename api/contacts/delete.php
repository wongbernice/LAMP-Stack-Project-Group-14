<?php
/**
 * EXPECTED METHOD:
 *   - POST
 *
 * EXPECTED INPUT (JSON):
 *   - id (contact id)  [required]
 *   - userId (owner id) 
 *
 * OUTPUT:
 *   - Success: {"id":<contactId>, "message":"...", "error":""}
 *   - Error:   {"id":-1, "error":"..."}
 *
 * NOTES:
 *   - Stubbed until DB is finalized.
 *   - DB section shows where to add your prepared DELETE query.
 */

require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";

$inData = getRequestInfo();

$contactId = $inData["id"] ?? "";
$userId    = $inData["userId"] ?? "";

if ($contactId === "") {
  returnWithError("Missing required field: id");
}

/****************************************************************
 * TEMP (NO DB YET)
 ****************************************************************/
returnWithInfo("Delete endpoint wired. DB delete is currently disabled.", (int)$contactId);

/****************************************************************
 * DATABASE (ENABLE LATER)
 ****************************************************************/
/*
require_once __DIR__ . "/../config/db.php";

// TODO: confirm schema/ownership rules.
// If contacts are scoped per-user, delete with BOTH id and userId.
// If not, delete only by id.

if ($userId !== "") {
  $stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=? AND UserID=?");
  if (!$stmt) returnWithError($conn->error);
  $stmt->bind_param("ii", $contactId, $userId);
} else {
  $stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=?");
  if (!$stmt) returnWithError($conn->error);
  $stmt->bind_param("i", $contactId);
}

if ($stmt->execute()) {
  if ($stmt->affected_rows === 0) {
    returnWithError("Contact not found");
  }
  returnWithInfo("Contact deleted", (int)$contactId);
} else {
  returnWithError($stmt->error);
}

$stmt->close();
$conn->close();
*/
?>
