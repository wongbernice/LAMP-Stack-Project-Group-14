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
$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
if( $conn->connect_error )
{
    returnWithError( $conn->connect_error );
}
else
{
    $stmt = $conn->prepare("SELECT Login,Password,ID,firstName,lastName FROM Users WHERE Login=? AND Password =?");
    $stmt->bind_param("ss", $inData["login"], $inData["password"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if( $row = $result->fetch_assoc()  )
    {
        returnWithError("User already created");
    }
    else
    {
        returnWithInfo( $row['Login'], $row['Password'], $row['ID']);
        return "New user created.";
    }

    $stmt->close();
    $conn->close();
}

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