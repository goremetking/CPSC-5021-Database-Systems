<html>
<head>
<title>New User</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>



<?php
$servername = "cssql.seattleu.edu";
$username = "lind2";
$password = "4EKud*pu";
$dbname = "lind2";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

extract($_REQUEST);

if($password == $confirmPassword) {
$sql = mysqli_prepare($conn, "INSERT INTO studentUser VALUES(?, MD5(?))");
mysqli_stmt_bind_param($sql, "ss", $username, $password);
mysqli_stmt_execute($sql);

	if(mysqli_affected_rows($conn) > 0) {

	/*	This is responsible for the transition into the myApplications page once an
		account is made*/
		echo "<div id=table>New account created successfully<br />";
		echo "<form action='myApplications.php' method='POST'>";
		echo "<input type='hidden' name='username' value=$username>"; /*These two lines put in whatever username and password is so it can be processed*/
		echo "<input type='hidden' name='password' value=$password>";
		echo "<input type='submit' value='Go to My Applications page'>";
		echo "</form></div>";

	}
	 else {
		echo "Error:" .$sql."<br/>".mysqli_error($conn);
	}

}
else {
	echo "<form action='createNewAccount.html'>";
	echo "Passwords do not match";
	echo "<p>";
	echo "<input type='submit' value='Go Back'>";
	echo "</form>";
}


mysqli_close($conn);
?>

</body>
</html>