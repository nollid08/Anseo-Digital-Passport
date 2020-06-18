<?php
// Load in the variables passed from JS
$uid = ($_POST['UID']);

// Connect to the DB
// Credentials to connect to the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL statement to retrieve amount of logs
$sql = "
	SELECT 
		count(*) amount_sql 
		FROM visits_logged 
		WHERE vl_person_uid = '$uid'
";

// Run the SQL statement and make sure that it was succesful
if ($result = mysqli_query($conn, $sql)) {
	$amount = $result->fetch_assoc();
	echo $amount['amount_sql'];
}

// Disconnect from the server
mysqli_close($conn);
?>