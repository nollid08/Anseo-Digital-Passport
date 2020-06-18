<?php

// Load in the variables passed from JS
$UID = ($_POST['UID']);
$COMMENT = ($_POST['COMMENT']);
$LOG_ID = ($_POST['LOG_ID']);
 
// Connect to the DB
// Credentials for the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// SQL statement to insert the comment into DB
$sql = "
UPDATE visits_logged
SET    vl_comment = '$COMMENT'
WHERE  vl_log_id = $LOG_ID";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {
	//SQL statement succeeded!
}else{
	echo ("Error: " . mysqli_query($conn, $sql) . mysqli_error($conn));
}

// Disconnect from the server
mysqli_close($conn);
?>
