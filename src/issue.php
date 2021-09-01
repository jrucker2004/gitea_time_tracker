<?php
$servername = "<server:port>";
$username = "<username>";
$password = "<password>";
$db = "<database>";
$issue_id_val = $_GET['issue_id'];


// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$issue_time_sql = mysqli_query($conn, "select issue_id, repo_name, project_title, issue_name, created_unix, logged_time from time_track_view where issue_id =" . $issue_id_val . "  order by created_unix");

// output data of each row
while($row = mysqli_fetch_array($issue_time_sql)) {
	$issue_id[] = $row['issue_id'];
	$repo_name[] = $row['repo_name'];
	$project_title[] = $row['project_title'];
        $issue_name[] = $row['issue_name'];
        $created_unix[] = $row['created_unix'];
        $logged_time[] = $row['logged_time'];

}

$len = count($issue_id);

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
echo "<h3>Project: " . $project_title[0] . "</h3>";
echo "<h3>Issue: " . $issue_name[0] . "</h3>";
echo "<table>";
echo "  <tr>";
echo "    <th>Date Log Entry Added</th>";
echo "    <th>Time Logged (hours)</th>";
echo "  </tr>";

for ($x = 0; $x < $len; $x++) {
  echo "  <tr>";
  echo "    <td>" . $created_unix[$x] . "</td>";
  echo "    <td>" . $logged_time[$x] . "</td>";
  echo "  </tr>";
}

echo "</table>";
echo "</body>";
echo "</html>";

$conn->close();
?>

