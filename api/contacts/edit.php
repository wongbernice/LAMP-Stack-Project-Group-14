<?php

require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../config/db.php";

$inData = getRequestInfo();

$contactId = $inData["id"] ?? "";
$userId    = $inData["userId"] ?? "";

$firstName = trim($inData["firstName"] ?? "");
$lastName  = trim($inData["lastName"] ?? "");
$phone     = trim($inData["phone"] ?? "");
$email     = trim($inData["email"] ?? "");


if ($contactId === "" || $userId === "") {
  returnWithError("Missing required fields: id, userId");
}

if ($firstName === "" && $lastName === "" && $phone === "" && $email === "") {
  returnWithError("No fields to update");
}

/***********************
 * UPDATE CONTACT
 ***********************/
$stmt = $conn->prepare(
  "UPDATE Contacts
   SET FirstName = ?, LastName = ?, Phone = ?, Email = ?
   WHERE ID = ? AND UserID = ?"
);

if (!$stmt) {
  returnWithError($conn->error);
}

$stmt->bind_param(
  "ssssii",
  $firstName,
  $lastName,
  $phone,
  $email,
  $contactId,
  $userId
);

if ($stmt->execute()) {
  if ($stmt->affected_rows === 0) {
    returnWithError("Contact not found or no changes made");
  }
  returnWithInfo("Contact updated", (int)$contactId);
} else {
  returnWithError($stmt->error);
}

$stmt->close();
$conn->close();
?>
