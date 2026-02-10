<?php
/**
 * FILE: api/auth/register.php
 * OWNER: S (Sameer)
 * PURPOSE:
 *   Create a new user account (Register).
 *
 * WHAT IT DOES:
 *   - Accepts registration fields (name, email/username, password).
 *   - Validates input and checks for duplicates (email/username already exists).
 *   - Hashes the password securely and stores the new user in the database.
 *   - Returns JSON success or JSON error with reason.
 *
 * EXPECTED METHOD:
 *   - POST
 *
 * EXPECTED INPUT:
 *   - JSON body or form fields (typical):
 *       name, email/username, password
 *
 * OUTPUT:
 *   - JSON success with created user id (and optionally auto-login/token)
 *   - JSON error if validation fails or user already exists
 *
 * DEPENDS ON:
 *   - ../config/db.php
 *   - ../helpers/response.php
 */
// Partially copied from /api/auth/login.php, which was copied from Colors project
$inData = getRequestInfo();

$id = 0;
$firstName = "";
$lastName = "";

$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
if( $conn->connect_error )
{
    returnWithError( $conn->connect_error );
}
else
{
    $checkStmt = $conn->prepare("SELECT 1 FROM Users where Login=?"); // Checks if User exists already
    $checkStmt->bind_param("s", $inData["login"]);
    if ($checkStmt->fetch()) {
        returnWithError( "Login already exists" );
    } else {
        $stmt = $conn->prepare("INSERT INTO Users Login,Password,FirstName,LastName WHERE Login=? AND Password =? AND FirstName=? AND LastName=?"); // Main register set
        $stmt->bind_param("ssss", $inData["login"], $inData["password"], $inData["firstName"], $inData["lastName"]);
        $stmt->execute();
        $result = $stmt->get_result();
        returnWithInfo($row['firstName'], $row['lastName'], $row['id']);
    }

    $checkStmt->close();
    $stmt->close();
    $conn->close();
}

/* Saving Google Gemini response here to mess with:
function user_exists_pdo($username, $pdo) {
    // Select a count of records matching the username
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    // Fetch the count
    $count = $stmt->fetchColumn();

    // Return true if count > 0, false otherwise
    return $count > 0;
}
 */

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson( $obj )
{
    header('Content-type: application/json');
    echo $obj;
}

function returnWithError( $err )
{
    $retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
}


function returnWithInfo( $firstName, $lastName, $id )
{
    $retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
    sendResultInfoAsJson( $retValue );
}
?>