<html>
<head>
<title>New Application</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="table">
		<h1>New Application</h1>
		<form action="personalInformation.php" method="POST">
			<label for="student-type">
				What type of Student are you?
			<?php 
				include_once 'optionValues.php';
				echo optionVal(stuTypeName, studentType);
			?>
			</label>
			<p>
			<label for="college-name">
				Which college are you applying to?
			<?php
				include_once 'optionValues.php';
				echo optionVal(collName, college);
			?>
			</label>
			<p>

			<label for="degree">
				What type of degree are you applying for?
			<?php
				include_once 'optionValues.php';
				echo optionVal(degType, degree);
			?>
			</label>
			<p>
			
			<label for="major">
				Please select the major you are applying to:
			<?php
				include_once 'optionValues.php';
				echo optionVal(majName, major);
			?>
			</label>
			<p>

			<label for="term">
				Choose the term you want to apply for:
			<?php
				include_once 'optionValues.php';
				echo optionVal(termName, term);
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