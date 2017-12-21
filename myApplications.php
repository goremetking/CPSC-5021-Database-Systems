<html>
<head>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>

<?php
$servername = "cssql.seattleu.edu";
$username = "lind2";
$password = "4EKud*pu";
$dbname = "lind2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
extract($_REQUEST);
$sql = mysqli_prepare($conn, "SELECT userName, password FROM studentUser WHERE userName = ? and password = ?");

mysqli_stmt_bind_param($sql, "ss", $username, MD5($password));
mysqli_stmt_execute($sql);
mysqli_stmt_bind_result($sql, $col1, $col2);

$i = 0;

while(mysqli_stmt_fetch($sql)) {
	$i++;
}

if($i > 0) {
	/*If log in is successful, it will use this to populate the page.*/
	session_start();
	$_SESSION['User'] = $col1;
	include 'applicationsRetrieve.php';

}
else {
	echo "<div id=table><h2>Log in fail!</h2>";
	echo "<form action = 'loginScreen.html'></div><div id=spacing></div>";
	echo "<input type='submit' value='Go Back'>";
	echo "</form>";
	mysqli_stmt_close($sql);
	mysqli_close($conn);
}

/*mysqli_stmt_close($sql);
mysqli_close($conn);*/
?>

</body>
</html>