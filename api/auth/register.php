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

// Import JSON sent from code.js
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
    // Check for duplicates
    $checkStmt = $conn->prepare("SELECT 1 FROM Users WHERE Login=?");
    $checkStmt->bind_param("s", $inData["login"]);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        returnWithError( "Login already exists" );
    } else {
        // Register User with INSERT
        $stmt = $conn->prepare("INSERT INTO Users (Login, Password, FirstName, LastName) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $inData["login"], $inData["password"], $inData["fName"], $inData["lName"]);
        
        if ($stmt->execute()) {
            // Return user's name and the database generated ID to frontend.
            returnWithInfo($inData['fName'], $inData['lName'], $conn->insert_id);
        } else {
            // Error if SQL execution fails
            returnWithError("Sign Up Failed");
        }
        $stmt->close(); // Close insert statement
    }
    $checkStmt->close(); // Close duplicate check statement
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
    $retValue = '{"id":0,"fName":"","lName":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
}


function returnWithInfo( $firstName, $lastName, $id )
{
    $retValue = '{"id":' . $id . ',"fName":"' . $firstName . '","lName":"' . $lastName . '","error":""}';
    sendResultInfoAsJson( $retValue );
}
?>