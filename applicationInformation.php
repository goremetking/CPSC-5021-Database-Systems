<html>
	<head>
	<title>Application Information</title>
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

		session_start();
		$appID = $_SESSION['applicationID'];
		extract($_REQUEST, EXTR_SKIP);

		$counter = 0;
		$ethnicCodes = "";
		foreach ($ethnicity as $result) {
			$ethnicCodes .= $result;
			$counter++;
		}

		$sql00 = mysqli_prepare($conn, "INSERT INTO personalInfo (perInFName, perInLName, perInPrefName, perInDOB, perInPhoneNum, perInStAddress, perInCity, perInState, locZipCode, perInUSCitizen, perInEngNative, perInGender, newAppID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
		mysqli_stmt_bind_param($sql00, "sssssssissssi", $perInFName, $perInLName, $perInPrefName, $perInDOB, $perInPhoneNum, $perInStAddress, $perInCity, $state, $locZipCode, $perInUSCitizen, $perInEngNative, $perInGender, $appID);
		$sql01 = mysqli_prepare($conn, "UPDATE newApplication SET vetStatusID = (?), milBranchID = (?) WHERE newAppID =" . $appID);
		mysqli_stmt_bind_param($sql01, "ii", $veteran, $militaryBranch);


		mysqli_stmt_execute($sql00);
		mysqli_stmt_close($sql00);
		mysqli_stmt_execute($sql01);
		mysqli_stmt_close($sql01);


		for($i = 0; $i < $counter; $i++)
		{
			$eCode = $ethnicCodes[$i];
			$sql02 = mysqli_prepare($conn, "INSERT INTO personalInfoEthnicity (newAppID, ethnCode, perInEthnHispLatOrigin) VALUES (?,?,?)");
			mysqli_stmt_bind_param($sql02, "iis", $appID, $eCode, $perInEthnHispLatOrigin);


			mysqli_stmt_execute($sql02);
			mysqli_stmt_close($sql02);
		}
		mysqli_close($conn);
	?>
	
	</head>
	<body>
		<div id="table">
			<h1>Application Information</h1>
			<form action="confirmation.php" method="POST">
			<label for="financial-aid">
				Will you be applying for financial aid?
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="yes">
					Yes
					<input type="radio" name="appInFinAid" value="Yes">
				</label>
				<label for="no">
					No
					<input type="radio" name="appInFinAid" value="No">
				</label>
			</label>
			<p>
			<label for="employer-tuition">
				Do you have employer tuition assistance?
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="yes">
					Yes
					<input type="radio" name="appInTuitAsst" value="Yes">
				</label>
				<label for="no">
					No
					<input type="radio" name="appInTuitAsst" value="No">
				</label>
			</label>
			<p>
			<label for="other-programs">
				Are you also applying to other programs?
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="yes">
					Yes
					<input type="radio" name="appInOthPgrms" value="Yes">
				</label>
				<label for="no">
					No
					<input type="radio" name="appInOthPgrms" value="No">
				</label>
			</label>
			<p>
		<div id="spacing"></div>
			<label for="convicted">
				Have you ever been convicted of a felony or a gross misdemeanor?
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="yes">
					Yes
					<input type="radio" name="appInConvicted" value="Yes">
				</label>
				<label for="no">
					No
					<input type="radio" name="appInConvicted" value="No">
				</label>
			</label>
			<p>
			<label for="suspended">
				A conviction will not necessarily bar admission but will require additional documentation
				prior to a decision. <br />You will be contacted shortly via email with instructions on reporting
				the nature of your conviction.
				<br />
				Have you ever been placed on probation, suspended from, dismissed from or otherwise
				sanctioned by (for any period of time) any higher education institution?
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="yes">
					Yes
					<input type="radio" name="appInProbSusp" value="Yes">
				</label>
				<label for="no">
					No
					<input type="radio" name="appInProbSusp" value="No">
				</label>
			</label>
			<p>
		</div>
		<div id="spacing"></div>

		<div id="table">
			<h2>Eductional History</h2>
				<label for="previous-education">
					Institution name: 
					<input type="text" size=50 name="prevEduInstitution">
				</label>
				<p>
				Attended <br />
				<label for="start-date">
					From: 
					<input type="date" size=50 name="prevEduStart">
				</label>
				<br />
				<label for="end-date">
					To: 
					<input type="date" size=50 name="prevEduEnd">
				</label>
				<p>
				<label for="degree-earned">
					Degree earned: 
					<input type="text" size=50 name="prevEduDegree">
				</label>
				<p>
				<label for="major">
					Major: 
					<input type="text" size=50 name="prevEduMajor">
				</label>
				<p>
				<label for="received-date">
					Degree received date 
					<input type="date" size=50 name="prevEduReceivedDate">
				</label>
				<p>
		</div>
		<div id="spacing"></div>

		<div id="table">
			<h2>Employment History</h2>
				<label for="employer-name">
					Employer/Organization name: 
					<input type="text" size=50 name="empName">
				</label>
				<p>
				<label for="current">
					Are you currently employed at this organization?
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="yes">
						Yes
						<input type="radio" name="jobCurrent" value="Yes">
					</label>
					<label for="no">
						No
						<input type="radio" name="jobCurrent" value="No">
					</label>
				</label>
				<p>
				<label for="street-address">
					Street address: 
					<input type="text" size=50 name="empStreetAddress">
				</label>
				<p>
				<label for="city">
					City: 
					<input type="text" size=50 name="empCity">
				</label>
				<p>
				<label for="state">
					State:
					<?php
						include_once 'optionValues.php';
						echo optionVal(stateName, state);
					?>
				</label>
				<p>
				<label for="zip">
					Zip code: 
					<input type="text" size=50 name="empZipCode">
				</label>
				<p>
				<label for="phone">
					Phone: 
					<input type="text" size=50 name="empPhone">
				</label>
				<p>
				<label for="job-title">
					Job Title: 
					<input type="text" size=50 name="jobTitle">
				</label>
				<p>
				<label for="start-date">
					Start date:
					<br /> 
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="start-month">
						Month:
						<input type="number" name="jobStartMonth" min="1" max="12" size="5">
					</label>
					<label for="start-year">
						Year:
						<input type="number" name ="jobStartYear" min="1980" max="2016">
					</label>
				</label>
				<br />
				<label for="end-date">
					End date: 
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="end-month">
						Month:
						<input type="number" name="jobEndMonth" min="1" max="12">
					</label>
					<label for="end-year">
						Year:
						<input type="number" name ="jobEndYear" min="1980" max="2016">
					</label>
				</label>
				<p>
				<label for="full-time">
					Full time 
					<input type="radio" name="jobFTPT" value="FT">
				</label>
				<label for="part-time">
					Part Time 
					<input type="radio" name="jobFTPT" value="PT">
				</label>
				<p>
		</div>
		<div id="spacing"></div>

		<div id="table">
			<h2>Entrance Tests</h2>
				<label for="tests-taken">
					Tests taken: 
						<?php
							include_once 'optionValues.php';
							echo optionVal(entrTestDescription, entranceTests);
						?>
				</label>
				<p>
				<label for="test-date">
					Test date: 
					<br />
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="month">
						Month:
						<input type="number" name="examMonth" min="1" max="12">
					</label>
					<label for="year">
						Year:
					<input type="number" name="examYear" min="1980" max="2016">
					</label>
				</label>
				<p>
		</div>
		<div id="spacing"></div>
		<div id="submit">
			<input type=submit value="Submit">
			<input type=reset value="Clear Form">
		</div>

	</body>
</html>