<?php
// Load in the variables passed from JS
$uid = ($_POST['UID']);
$log_id = ($_POST['LOG_ID']);

// Connect to the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL statement to retrieve the image location from the DB
$sql = "
SELECT vl_image from visits_logged
WHERE vl_log_id = $log_id AND vl_person_uid = '$uid';";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {
    // Get the returned image location
    $result = mysqli_query($conn, $sql);
    // Get the row from the result
    $row = mysqli_fetch_assoc($result); 
    // Get the image url from the row
    $imageUrl = $row['vl_image'];     
    echo($imageUrl);

}else{
    echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Disconnect from the server
mysqli_close($conn);
?>