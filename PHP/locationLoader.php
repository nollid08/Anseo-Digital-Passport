<?php
// Load in the DB credentials
include 'Include/credentials.php';

// Connect to the DB
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL statement to retrieve the Discovery Point from the DB
$sql = "SELECT
                dp_point_id,
                dp_point_name,
                dp_county,
                dp_latitude,
                dp_longitude 
        FROM
                discovery_points";

// Create a 2D array to store the Discovery Points
$locations = array();

// Run the SQL query
$result = mysqli_query($conn, $sql);

// Verify that the data was recieved from the server
if (mysqli_num_rows($result) > 0) {
    // Loop through each row
    while($row = mysqli_fetch_assoc($result)) {
        // Create a temporary array with the row data in it
        $Temp_Locations = array(utf8_encode($row["dp_point_name"]), $row["dp_latitude"], $row["dp_longitude"], $row["dp_county"], $row["dp_point_id"]);
        
        // Push the temporary array to $locations
        array_push($locations, $Temp_Locations); 
        }
    // Encode $locations as JSON and send it back to JS
    echo (json_encode($locations, JSON_UNESCAPED_UNICODE));
} else {
    echo "0 results";
}

// Disconnect from the server
mysqli_close($conn);
?>