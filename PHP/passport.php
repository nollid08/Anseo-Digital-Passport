<?php
// Retrieve the variables from JS
$uid = ($_POST['UID']);
$onMobile = ($_POST['onMobile']);

// Connect to the DB

// Import credentials to connect to the DB
include 'Include/credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check to make sure that the connection was not unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* SQL statement to retrieve the users logs */
$sql = "SELECT
			*
		FROM
			visits_logged
		INNER JOIN 
			discovery_points 
		ON 
			discovery_points.dp_point_id = visits_logged.vl_point_id
		WHERE
			visits_logged.vl_person_uid = '$uid'
		ORDER BY 
			vl_log_id DESC;
";

// Run the SQL statement and make sure that it was succesful
if (mysqli_query($conn, $sql)) {

    // Get the result
    $result = mysqli_query($conn, $sql);

	// Echo the beginning of the table
	echo "<table id = 'logTable'>
	<thead>
	<tr>
	<th class = 'DP'>Discovery Point:</th>
	<th class = 'Date'>Date</th>
	<th class = 'Time'>Time</th>
	<th class = 'County'>County</th>
	<th class = 'Comment'>Comment</th>

	</tr>
	</thead>
	<tbody>";

	// Loop through each SQL Table row and echo it as a table row
	while($row = mysqli_fetch_array($result)) {
		// If the user is on a computer
		if($onMobile == 0){   
			// If the discovery point name is small enough
			if(strlen($row['dp_point_name']) < 19){
				// Leave it as it is
				$pointName = $row['dp_point_name'];
			}else{
				// If not, shorten it
				$pointName = substr ($row['dp_point_name'], 0 , 16) . "...";
			}
		}else{
			// The user is on a computer

			// If the discovery point name is small enough
			if(strlen($row['dp_point_name']) < 10){
				// Leave it as it is
				$pointName = $row['dp_point_name'];
			}else{
				// If not, shorten it
				$pointName = substr ($row['dp_point_name'], 0 , 13) . "...";
			}
		}

		// If the comment is short enough
		if(strlen($row['vl_comment']) < 13){
			// Leave it as it is
		$comment = $row['vl_comment'];
		}else{
			// If not, shorten it
			$comment = substr ($row['vl_comment'], 0 , 13) . "...";
		}

		// Echo the SQL table row as a html row
		echo "<tr data-href='" .$row['vl_log_id'] . "' >";
		echo "<td class = 'DP'>" .  $pointName . "</td>";
		echo "<td class = 'Date'>" . $row['vl_date'] . "</td>";
		echo "<td class = 'Time'>" . $row['vl_time'] . "</td>";
		echo "<td class = 'County'>" . $row['dp_county'] . "</td>";
		echo "<td class = 'Comment'>" . $comment . "</td>";

		echo "</tr>";
	}
	// Echo the end of the table
	echo "
	</tbody>
	</table>";
}else{
	// If there was an error
	echo ("Error: " . $sql . "<br>" . mysqli_error($conn));
}
mysqli_close($conn);
?>
