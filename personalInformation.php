<html>
	<head>
	<title>Personal Information</title>
	<link href="styles.css" type="text/css" rel="stylesheet" />
	
	<?php
		$servername = "cssql.seattleu.edu";
		$username = "lind2";
		$password = "4EKud*pu";
		$dbname = "lind2";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}


		session_start(); /*Took the session from the login, it works here too and I moved the value into a variable*/
		$user = $_SESSION['User'];
		extract($_REQUEST, EXTR_SKIP);

		$sql = mysqli_prepare($conn, 
			"INSERT INTO newApplication
			(stuTypeCode, degCode, majCode, collCode, termCode, userName)
			VALUES (?,?,?,?,?,?)");
		mysqli_stmt_bind_param($sql, "iiiiis", $studentType, $degree, $major, $college, $term, $user);
		mysqli_stmt_execute($sql);

		
		if(mysqli_affected_rows($conn) > 0)
		{
			$last_newAppID = mysqli_insert_id($conn);
			$_SESSION['applicationID'] = $last_newAppID;
		}

		else 
		{
			echo "Database connection error.";
		}
		mysqli_stmt_close($sql);
		mysqli_close($conn);
	?>

	</head>
	<body>
		<div id="table">
			<h1>Personal Information</h1>
			<form action="applicationInformation.php" method="POST">
				<label for="last-name">
					Last name: <input type="text" size=50 name="perInLName">
				</label>
				<p>
				<label for="first-name">
					First name: <input type="text" size=50 name="perInFName">
				</label>
				<p>
				<label for="preferred-name">
					Preferred name: <input type="text" size=50 name="perInPrefName">
				</label>
				<p>
				<label for="date-of-birth">
					Date of Birth: <input type="date" size=50 name="perInDOB">
				</label>
				<p>
				<label for="mailing-address">
					Mailing address<br />
					<label for="street-address">
						&nbsp;&nbsp;&nbsp;&nbsp;
						Street Address:	<input type="text" size=50 name="perInStAddress">
					</label>
					<p>
					<label for="city">
						&nbsp;&nbsp;&nbsp;&nbsp;
						City: <input type="text" size=50 name="perInCity">
					</label>
					<p>
					<label for="state">
						&nbsp;&nbsp;&nbsp;&nbsp;
						State:
						<?php
							include_once 'optionValues.php';
							echo optionVal(stateName, state);
						?>
					</label>
					<p>
					<label for="zip">
						&nbsp;&nbsp;&nbsp;&nbsp;
						Zip code: <input type="text" size=50 name="locZipCode">
					</label>
				</label>
				<p>
				<label for="phone-number">
					Preferred phone number: <input type="text" size=50 name="perInPhoneNum">
				</label>
				<p>
				<label for="US-citizen">
					Are you a US citizen? 
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="yes">
						Yes
						<input type="radio" name="perInUSCitizen" value="Yes">
					</label>
					<label for="no">
						No
						<input type="radio" name="perInUSCitizen" value="No">
					</label>
				</label>
				<p>
				<label for="english-native">
					Is English your native language?
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="yes">
						Yes
						<input type="radio" name="perInEngNative" value="Yes">
					</label>
					<label for="no">
						No
						<input type="radio" name="perInEngNative" value="No">
						</label>
				</label>
				<p>
				<label for="gender">
					Gender:
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="male">
						Male
						<input type="radio" name="perInGender" value="Male">
					</label>
					<label for="female">
						Female
						<input type="radio" name="perInGender" value="Female">
					</label>
				</label>
				<p>
				<label for="vet-status">
					Please tell us your veteran status:
					<?php
						include_once 'optionValues.php';
						echo optionVal(vetStatus, veteran);
					?>
				</label>
				<p>
				<label for="military-branch">
					Military branch:
					<?php
						include_once 'optionValues.php';
						echo optionVal(milBranchName, militaryBranch);
					?>
				</label>
				<p>
				<label for="hispanic-or-latino">
					Are you Hispanic/Latino origin?
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="yes">
						Yes
						<input type="radio" name="perInEthnHispLatOrigin" value="Yes">
					</label>
					<label for="no">
						No
						<input type="radio" name="perInEthnHispLatOrigin" value="No">
					</label>
				</label>
				<p>
				<label for="ethnicity">
					Please mark all that apply:
					<br />
					<?php
						include_once 'checkboxValues.php';
					?>
				</label>
				<p>
			</div>
		<div id="spacing"></div>
		<div id="submit">
			<input type=submit value="Submit">
			<input type=reset value="Clear Form">
		</div>
		</form>
	</body>
</html>

