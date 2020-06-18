<?php
// Load in the variables passed from JS
$uid = ($_POST['UID']);
$log_id = ($_POST['LOG_ID']);

// Connect to the DB
include 'Include/credentials.php';

// Hide warnings from output
error_reporting(0);

// Set the timezone to Dublin
date_default_timezone_set("Europe/Dublin");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL statement to retrieve log name, date and time DB
$sql = "SELECT vl_point_name, vl_date
        FROM   visits_logged 
        WHERE  vl_log_id = $log_id 
        AND vl_person_uid = '$uid'; ";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {
    // Get the result
    $result = mysqli_query($conn, $sql);
    // Fetch the row with all the data in it
    $row = mysqli_fetch_assoc($result); 
    // Get the data and name from the row
    $date = $row['vl_date'];
    $name = $row["vl_point_name"];

    // Use mktime() and date() function to 
    // convert the raw date to a nice string 
    $date = date("l \\t\\h\\e jS \\o\\f F Y", mktime($date)); 

    // Send the point name and date back to JS 
    echo $name . ", " . $date;
}else{
    echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Disconnect from the server
mysqli_close($conn);
?>