<?php
// Retrieve the variables from JS
$LOG_ID = ($_POST['logId']);
$UID = ($_POST['UID']);
$IMAGE = ($_POST['image']);

// Connect to the DB

// Import credentials to connect to the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* SQL statement to retrieve the previous image location from the DB
   to send back to js to delete the old image */
$sql = "
SELECT vl_image FROM visits_logged 
WHERE vl_log_id = $LOG_ID
AND vl_person_uid = '$UID'";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {
    // Get the result
    $result = mysqli_query($conn, $sql);
    // Get the row from the result
    $row = mysqli_fetch_assoc($result); 
    // Get the image url from the row
    $imageUrl = $row['vl_image']; 
    // Send the image url back to JS       
    echo($imageUrl);

    // New SQL statement to update the DB to match the new image location
    $sql = "
    UPDATE visits_logged
    SET    vl_image = '$IMAGE'
    WHERE  vl_log_id = '$LOG_ID'";

    // Run the SQL statement and make sure that it was succesful
    if (mysqli_query($conn, $sql)) {
        //Success
    }else{
        echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
    }
}

// Disconnect from the server
mysqli_close($conn);
?>