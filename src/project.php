<?php
$servername = "<server:port>";
$username = "<username>";
$password = "<password>";
$db = "<database>";
$project_id_val = $_GET['project_id'];


// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$issue_time_sql = mysqli_query($conn, "select issue_id, repo_name, project_title, issue_name, sum(logged_time) as logged_time from time_track_view where project_id =" . $project_id_val . "  group by issue_id order by issue_name");

// output data of each row
while($row = mysqli_fetch_array($issue_time_sql)) {
        $issue_id[] = $row['issue_id'];
        $repo_name[] = $row['repo_name'];
        $project_title[] = $row['project_title'];
        $issue_name[] = $row['issue_name'];
        $logged_time[] = $row['logged_time'];

}

$len = count($issue_id);

// Convert time from seconds to hours/minutes

for ($x = 0; $x < $len; $x++) {
        $logged_time[$x] = round($logged_time[$x] / 3600,2);

}


/******************************
 *
 * Display a table of time entries for the issue
 *
 ******************************/
echo "<html>";
echo "<head>";
echo '<link rel="stylesheet" href="style.css">';
echo '<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>';
echo "</head>";
echo "<body>";
echo "<h2>Repository: " . $repo_name[0] . "</h2>";
echo "<h3>Project: " . $project_title[0] . "</h3>";
echo "<table>";
echo "  <tr>";
echo "    <th>Issue Name</th>";
echo "    <th>Cumalitive Time Logged (hours)</th>";
echo "  </tr>";

for ($x = 0; $x < $len; $x++) {
  echo "  <tr>";
  echo "    <td>" . $issue_name[$x] . "</td>";
  echo "    <td>" . $logged_time[$x] . "</td>";
  echo "  </tr>";
}

echo "</table>";
/******************************
 *
 * Display a fancy bar graph
 *
 ******************************/

echo '<script type="text/javascript">';
echo '  window.onload = function () {';
echo '    var chart = new CanvasJS.Chart("chartContainer", {';
echo '      title:{';
echo '        text: "Time Logged for Projects"';
echo '      },';
echo '      data: [';
echo '      {';
echo '        type: "bar",';
echo '        dataPoints: [';

for ($x = 0; $x < $len; $x++) {
  echo '          { label: `' .  $issue_name[$x] . '`, y: ' . $logged_time[$x] . '},';
}

echo '        ]';
echo '      }';
echo '      ]';
echo '    });';
echo '    chart.render()';
echo '  }';
echo '</script>';
echo '<br>';
echo '<div id="chartContainer" style="height: 300px; width: 100%;">';
echo "</body>";
echo "</html>";

$conn->close();
?>

