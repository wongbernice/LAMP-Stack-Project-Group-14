<?php

require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../config/db.php";

# read input
$inData = getRequestInfo();

# extract files
$firstName = trim($inData["firstName"] ?? "");
$lastName  = trim($inData["lastName"] ?? "");
$phone     = trim($inData["phone"] ?? "");
$email     = trim($inData["email"] ?? "");
$userId    = $inData["userId"] ?? "";

if ($userId === "" || $firstName === "" || $lastName === "") {
  returnWithError("Missing required fields: userId, firstName, lastName");
}

# database

$stmt = $conn->prepare(
  "INSERT INTO Contacts (FirstName, LastName, Phone, Email, UserID)
   VALUES (?, ?, ?, ?, ?)"
);

if (!$stmt) {
  returnWithError($conn->error);
}

$stmt->bind_param("ssssi", $firstName, $lastName, $phone, $email, $userId);

if ($stmt->execute()) {
  $newId = $conn->insert_id;
  returnWithInfo("Contact added", (int)$newId);
} else {
  returnWithError($stmt->error);
}

$stmt->close();
$conn->close();

?>
