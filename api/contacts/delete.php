<?php
require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../config/db.php";

$inData = getRequestInfo();

$contactId = $inData["id"] ?? "";
$userId    = $inData["userId"] ?? "";

if ($contactId === "" || $userId === "") {
  returnWithError("Missing required fields: id, userId");
}

$stmt = $conn->prepare(
  "DELETE FROM Contacts WHERE ID=? AND UserID=?"
);

if (!$stmt) {
  returnWithError($conn->error);
}

$stmt->bind_param("ii", $contactId, $userId);

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
?>
