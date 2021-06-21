<?php
$servername = "<server:port>";
$username = "<username>";
$password = "<password>";
$db = "<db>";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$issues_sql = mysqli_query($conn, "select distinct repo_id, repo_name, project_id, project_title, issue_id, issue_name from time_track_view order by repo_name, project_title, issue_name");

// output data of each row
while($row = mysqli_fetch_array($issues_sql)) {
	$repo_id[] = $row['repo_id']; 
	$repo_name[] = $row['repo_name'];
	$project_id[] = $row['project_id'];
	$project_title[] = $row['project_title'];
	$issue_id[] = $row['issue_id'];
	$issue_name[] = $row['issue_name'];
	  
}

$len = count($repo_id);

/******************************
/
/ Display a table of issues, with their associated project and repo
/
******************************/
echo "<html>";
echo "<head>";
echo '<link rel="stylesheet" href="style.css">';
echo "</head>";
echo "<body>";
echo "<h1>Gitea Projects with logged time</h1>";
echo "<table>";
echo "  <tr>";
echo "    <th>Repo Name</th>";
echo "    <th>Project Title</th>";
echo "    <th>Issue Name</th>";
echo "  </tr>";

for ($x = 0; $x < $len; $x++) {
  echo "  <tr>";
  echo "    <td><a href='repo.php?repo_id=" . $repo_id[$x] . "'>"  . $repo_name[$x] . "</td>";
  echo "    <td><a href='project.php?project_id=" . $project_id[$x] . "'>" . $project_title[$x] . "</td>";
  echo "    <td><a href='issue.php?issue_id=" . $issue_id[$x] . "'>" . $issue_name[$x] . "</a></td>";
  echo "  </tr>";
}

echo "</table>";
echo "<br>";
echo "<p>Can't find your issue?  Make sure it's linked to a project in gitea.</p>";
echo "</body>";
echo "</html>";

$conn->close();
?>



