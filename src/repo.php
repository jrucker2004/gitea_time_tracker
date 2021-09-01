<?php
$servername = "<server:port>";
$username = "<username>";
$password = "<password>";
$db = "<database>";
$repo_id_val = $_GET['repo_id'];


// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$issue_time_sql = mysqli_query($conn, "select project_id, repo_name, project_title, sum(logged_time) as logged_time from time_track_view where repo_id =" . $repo_id_val . "  group by project_id order by project_title");

// output data of each row
while($row = mysqli_fetch_array($issue_time_sql)) {
        $project_id[] = $row['project_id'];
        $repo_name[] = $row['repo_name'];
        $project_title[] = $row['project_title'];
        $logged_time[] = $row['logged_time'];

}

$len = count($project_id);

// Convert time from seconds to hours/minutes

for ($x = 0; $x < $len; $x++) {
	$logged_time[$x] = round($logged_time[$x] / 3600,2);

}


/******************************
/
/ Display a table of time entries for the issue
/
******************************/
echo "<html>";
echo "<head>";
echo '<link rel="stylesheet" href="style.css">';
echo "</head>";
echo "<body>";
echo "<h2>Repository: " . $repo_name[0] . "</h2>";
echo "<table>";
echo "  <tr>";
echo "    <th>Project Title</th>";
echo "    <th>Time Logged (hours)</th>";
echo "  </tr>";

for ($x = 0; $x < $len; $x++) {
  echo "  <tr>";
  echo "    <td>" . $project_title[$x] . "</td>";
  echo "    <td>" . $logged_time[$x] . "</td>";
  echo "  </tr>";
}

echo "</table>";
echo "</body>";
echo "</html>";

$conn->close();
?>

