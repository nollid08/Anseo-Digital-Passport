<?php
// Load in the variables passed from JS
$UID = ($_POST['UID']); 
$closestPointId = ($_POST['cpId']); 
$closestPointName = ($_POST['cpName']); 
 
// Connect to the DB
// Credentials to connect to the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the timezone to Dublin
date_default_timezone_set("Europe/Dublin");
// Save the date and time as vaiables
$date = date("d-m-Y");
$time = date("h:i:sa");

// SQL statement to insert the log data into DB
$sql = "
	INSERT INTO visits_logged (
		vl_point_id
		,vl_point_name
		,vl_person_uid
		,vl_date
		,vl_time
		,vl_comment
		)
	VALUES (
		'$closestPointId'
		,'$closestPointName'
		,'$UID'
		,'$date'
		,'$time'
		,'Add A Comment(Max 255 Characters)...'
		);

";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {

	//SQL statement to get the ID of the log that was just entered into the DB
	$sql = "
	SELECT @log_id := Max(vl_log_id)
	FROM   visits_logged
	WHERE  vl_person_uid = '$UID';
	";

	// Run the SQL statement and make sure that it was succesful
	if (mysqli_query($conn, $sql)) {

		// Get the returned Log ID
		$result = mysqli_query($conn, $sql);
		$log_id_array = mysqli_fetch_array($result);
		$log_id = $log_id_array[0];     
		// Send the Log ID back to JS
		echo($log_id);
	}else{
		echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
	}
}else{
    echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Disconnect from the server
mysqli_close($conn);
?>