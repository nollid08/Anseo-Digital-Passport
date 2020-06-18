<?php
$LOG_ID = ($_POST['LOG_ID']); //the var you put in your ajax data:{}
$UID = ($_POST['UID']); //the var you put in your ajax data:{}
 
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
    DELETE 
        FROM 
            visits_logged 
        WHERE 
            vl_log_id = $LOG_ID 
        AND 
            vl_person_uid = '$UID';";

// Run the SQL statement and make sure that it was succesful
if (!mysqli_query($conn, $sql)) {
    echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}

?>