<?php
/************************************************************
 *
 * EXPECTED JSON BODY:
 * {
 *   "firstName": "Angelo",
 *   "lastName": "Villanueva",
 *   "phone": "407-555-1234",
 *   "email": "angelo@example.com",
 *   "userId": 1
 * }
 *
 * RESPONSE FORMAT (consistent):
 *  - Success: {"id": <newContactId or -1>, "message": "...", "error":""}
 *  - Error:   {"id": -1, "error":"..."}
 ************************************************************/

require_once __DIR__ . "/../helpers/headers.php";
require_once __DIR__ . "/../helpers/request.php";
require_once __DIR__ . "/../helpers/response.php";

/***********************
 * 1) READ JSON INPUT
 ***********************/
$inData = getRequestInfo();

/***********************
 * 2) EXTRACT FIELDS
 ***********************/
$firstName = trim($inData["firstName"] ?? "");
$lastName  = trim($inData["lastName"] ?? "");
$phone     = trim($inData["phone"] ?? "");
$email     = trim($inData["email"] ?? "");
$userId    = $inData["userId"] ?? "";

/***********************
 * 3) VALIDATE REQUIRED
 ***********************/
if ($userId === "" || $firstName === "" || $lastName === "") {
  returnWithError("Missing required fields: userId, firstName, lastName");
}

/****************************************************************
 * 4) TEMP (NO DB YET)
 *    - Return success so your frontend can integrate now.
 ****************************************************************/
returnWithInfo("Add endpoint wired. DB insert is currently disabled.", -1);

/****************************************************************
 * 5) DATABASE(ENABLE LATER)
 ****************************************************************/

/*
require_once __DIR__ . "/../config/db.php";

// TODO: Make sure your table/column names match your schema.
// Example schema assumption:
//   Contacts(ID, FirstName, LastName, Phone, Email, UserID)

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
*/
?>
