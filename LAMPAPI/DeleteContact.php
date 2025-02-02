<?php

	$inData = getRequestInfo();
	
	$UserID = $inData["UserID"];
	$ID = $inData["ID"];
	
	$conn = new mysqli("localhost", "NotTheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) {
		returnWithError($conn->connect_error);
	} else {
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE UserID = ? AND ID = ?");
		$stmt->bind_param("ss", $UserID, $ID);
		$stmt->execute();
		if ($stmt->affected_rows == 0) {
			returnWithError("Contact not found");
		}
		$stmt->close();
		$conn->close();
		returnWithError("");
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
