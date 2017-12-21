<html>
<head>
<title>My Applications</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body><div id="table">
<?php
	session_start();

	$userName = $_SESSION['User'];
	echo "<h1><strong>";
	echo "Welcome " . $userName . ".";
	echo "</strong></h1>";
?>

<h3><strong>Here are your applications: </strong></h3>
</div><div id="spacing"></div>

<?php
$servername = "";
$username = "";
$password = "*pu";
$dbname = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
session_start();
$user = $_SESSION['User'];


$sql = "SELECT newAppID, collName, degtype, majName, termName
from newApplication
natural join college
natural join degree
natural join major
natural join term
where newApplication.userName = '$user'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
	echo "<div id=table><table border = '1'>\n";
	echo "<h3> My Applications </h3>";
	echo "<tr>";
	echo "<td align='center'><b>App ID</b></td>";
	echo "<td align='center'><b>College</b></td>";
	echo "<td align='center'><b>Degree</b></td>";
	echo "<td align='center'><b>Major</b></td>";
	echo "<td align='center'><b>Term</b></td>";
	while($row = mysqli_fetch_row($result)) {
		echo "<tr>\n";
    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
    	/*singled out the first row so I can change it into a link*/
    	if($i == 0) {
    		$id = $row[0];
    		echo "<td><a href='viewApplication.php?id=$id'>" .$id. "</a></td>";
    	} 
    	else {
       		echo "<td>". $row[$i] . "</td>\n";
   		}
    }
    echo "</tr>\n";
  }
  echo "</table></div>\n";

}



else {
	echo "No applications at the moment...";
}

mysqli_free_result($result);
mysqli_close($conn);
?>
<div id="spacing"></div>
<form action='newApplication.php'>
	<input type='submit' value='Create New Application'>
</form>
<form action='loginScreen.html'>
	<input type='submit' value="Logout">
</form>
</body>
</html>
