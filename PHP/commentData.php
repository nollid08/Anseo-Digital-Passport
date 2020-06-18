<?php

// Load in the variables passed from JS
$uid = ($_POST['UID']);
$log_id = ($_POST['LOG_ID']);

// Connect to the DB
// Credentials for the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//SQL statement to retrieve comment data from DB
$sql = "
SELECT vl_comment from visits_logged
WHERE vl_log_id = $log_id AND vl_person_uid = '$uid';";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {
    // Get the result
    $result = mysqli_query($conn, $sql);
    // Fetch array from the result
    $commentDataArray = mysqli_fetch_array($result);
    // Get the comment data from the array
    $commentData = $commentDataArray[0]; 
    // Send the comment data back to JS       
    echo($commentData);

}else{
echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Disconnect from the server
mysqli_close($conn);
?>

