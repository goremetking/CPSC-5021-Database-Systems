<html>
<head>
<title>View Application</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>

<?php
    $servername = "cssql.seattleu.edu";
    $username = "lind2";
    $password = "4EKud*pu";
    $dbname = "lind2";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    echo "<div id='table'>";
    echo "<h1>Confirmation</h1>";
    extract($_REQUEST);
    if($appID == NULL) {
    $appID = $id;
    }

    echo "<h2>New Application</h2>";


    $studentType = "SELECT stuTypeName FROM newApplication, studentType WHERE newApplication.newAppID = $appID 
    AND newApplication.stuTypeCode = studentType.stuTypeCode";
    $stuResult = mysqli_query($conn, $studentType);
    if (mysqli_num_rows($stuResult) > 0) {
      while ($row = mysqli_fetch_assoc($stuResult)) {
        echo "What type of student are you? " . $row["stuTypeName"] . "<p>";
      }
    }

    $college = "SELECT collName FROM newApplication, college WHERE newApplication.newAppID = $appID 
    AND newApplication.collCode = college.collCode";
    $colResult = mysqli_query($conn, $college);
    if (mysqli_num_rows($colResult) > 0) {
      while ($row = mysqli_fetch_assoc($colResult)) {
        echo "Which college are you applying to? " . $row["collName"] . "<p>";
      }
    }

    $degree = "SELECT degType FROM newApplication, degree WHERE newApplication.newAppID = $appID 
    AND newApplication.degCode = degree.degCode";
    $degResult = mysqli_query($conn, $degree);
    if (mysqli_num_rows($degResult) > 0) {
      while ($row = mysqli_fetch_assoc($degResult)) {
        echo "What type of degree are you applying for? " . $row["degType"] . "<p>";
      }
    }

    $major = "SELECT majName FROM newApplication, major WHERE newApplication.newAppID = $appID 
    AND newApplication.majCode = major.majCode";
    $majResult = mysqli_query($conn, $major);
    if (mysqli_num_rows($majResult) > 0) {
      while ($row = mysqli_fetch_assoc($majResult)) {
        echo "Please select the major your are applying to " . $row["majName"] . "<p>";
      }
    }

    $term = "SELECT termName FROM newApplication, term WHERE newApplication.newAppID = $appID 
    AND newApplication.termCode = term.termCode";
    $terResult = mysqli_query($conn, $term);
    if (mysqli_num_rows($terResult) > 0) {
      while ($row = mysqli_fetch_assoc($terResult)) {
        echo "Term ". $row["termName"] . "<p>";
      }
    }
    echo "</div><div id='spacing'></div><div id='table'>";
    echo "<h2>Personal Information</h2>";

    $personalInfo = "SELECT * FROM personalInfo WHERE newAppId = $appID";
    $perInfResult = mysqli_query($conn, $personalInfo);
    if (mysqli_num_rows($perInfResult) > 0) {
      while ($row = mysqli_fetch_assoc($perInfResult)) {
        echo "Name " . $row["perInFName"] . " " . $row["perInLName"] . "<p>";
        echo "Preferred Name " . $row["perInPrefName"] . "<p>";
        echo "Date of Birth " . $row["perInDOB"] . "<p>";
        echo "Mailing Address " . $row["perInStAddress"] . " " . $row["perInCity"] . " ";
      }
    }

    $personalState = "SELECT stateName FROM personalInfo, state WHERE personalInfo.newAppID = $appID 
    AND personalInfo.perInState = state.statecode";
    $perStaResult = mysqli_query($conn, $personalState);
    if (mysqli_num_rows($perStaResult) > 0) {
      while ($row = mysqli_fetch_assoc($perStaResult)) {
        echo $row["stateName"] . " ";
      }
    }

    $perInfResult = mysqli_query($conn, $personalInfo);
    if (mysqli_num_rows($perInfResult) > 0) {
      while ($row = mysqli_fetch_assoc($perInfResult)) {
        echo $row["locZipCode"] . "<p>";
        echo "Preferred phone number " . $row["perInPhoneNum"] . "<p>";
        echo "Are you a US Citizen? " . $row["perInUSCitizen"] . "<p>";
        echo "Is English your native language? " . $row["perInEngNative"] . "<p>";
        echo "Gender? " . $row["perInGender"] . "<p>";
      }
    }

    $vetStatus = "SELECT vetStatus FROM veteran, newApplication WHERE newApplication.newAppID = $appID 
    AND newApplication.vetStatusID = veteran.vetStatusID";
    $vetStatusResult = mysqli_query($conn, $vetStatus);
    if (mysqli_num_rows($vetStatusResult) > 0) {
      while ($row = mysqli_fetch_assoc($vetStatusResult)) {
        echo "Please tell us your veteran status " . $row["vetStatus"] . "<p>";
      }
    }

    $militaryBranch = "SELECT milBranchName FROM newApplication, militaryBranch WHERE newApplication.newAppID = $appID 
    AND newApplication.milBranchID = militaryBranch.milBranchID";
    $milBraResult = mysqli_query($conn, $militaryBranch);
    if (mysqli_num_rows($milBraResult) > 0) {
      while ($row = mysqli_fetch_assoc($milBraResult)) {
        echo "Military Branch " . $row["milBranchName"] . "<p>";
      }
    }

    $hisLatOirigin = "SELECT perInEthnHispLatOrigin FROM personalInfoEthnicity WHERE newAppID = $appID";
    $hisLatResult = mysqli_query($conn, $hisLatOirigin);
    if (mysqli_num_rows($hisLatResult) > 0) {
      while ($row = mysqli_fetch_assoc($hisLatResult)) {
        echo "Are you Hispanic/Latino origin? " . $row["perInEthnHispLatOrigin"] . "<p>";
      }
    }

    /*
    Fetch the string from the ethnicity column and then iterate through each char
    */
    echo "Please mark all that apply: ";
    $ethnString = "";
    $ethnicity = "SELECT ethnCode FROM personalInfoEthnicity WHERE newAppID = $appID";
    $ethnicityResult = mysqli_query($conn, $ethnicity);
    if (mysqli_num_rows($ethnicityResult) > 0) {
      while ($row = mysqli_fetch_assoc($ethnicityResult)) {
        $ethnString .= $row["ethnCode"];
      }
    }
    $strlen = strlen($ethnString);
    for ($i = 0; $i < $strlen; $i++) {
      $char = substr($ethnString, $i, 1);
      $ethn = "SELECT ethnType FROM ethnicity WHERE ethnCode =" . $char . "";
      $ethnResult = mysqli_query($conn, $ethn);
      if (mysqli_num_rows($ethnResult) > 0) {
        while ($row = mysqli_fetch_assoc($ethnResult)) {
          echo $row["ethnType"] . " ";
        }
      }
    }

    echo "</div>";
    echo "<div id='spacing'></div><div id='table'>";
    echo "<h2>Application Information</h2>";
    $applicationInfo = "SELECT * FROM applicationInfo WHERE newAppID = $appID";
    $appInfResult = mysqli_query($conn, $applicationInfo);
    if (mysqli_num_rows($appInfResult) > 0) {
      while ($row = mysqli_fetch_assoc($appInfResult)) {
        echo "Will you be applying for financial aid? " . $row["appInFinAid"] . "<p>";
        echo "Do you have employer tuition assistance? " . $row["appInTuitAsst"] . "<p>";
        echo "Are you also applying to other programs? " . $row["appInOthPgrms"] . "<p>";
        echo "Have you ever been convicted of a felony or a gross misdemeanor? " . $row["appInConvicted"] . "<p>";
        echo "A conviction will not necessarily bar admission but will require additional documentation prior to 
        a decision. You will be contactd shortly via email with insturctions on reporting the natgure of your conviction.<br />";
        echo "Have you ever been placed on probation, suspended from, dismissed from or otherwise sanctioned by (for any period of time) 
        any higher education institution?<p>" . $row["appInProbSusp"] . "<p>";
      }
    }

    echo "</div>";
    echo "<div id='spacing'></div><div id='table'>";
    echo "<h2>Educational History</h2>";
    $previousEducation = "SELECT * FROM previousEducation WHERE newAppID = $appID";
    $preEduResult = mysqli_query($conn, $previousEducation);
    if (mysqli_num_rows($preEduResult) > 0) {
      while ($row = mysqli_fetch_assoc($preEduResult)) {
        echo "Institution " . $row["prevEduInstitution"] . "<p>";
        echo "Attended from/to (month and year) " . $row["prevEduStart"] . " " . $row["prevEduEnd"] . "<p>";
        echo "Degree earned " . $row["prevEduDegree"] . "<p>";
        echo "Major " . $row["prevEduMajor"] . "<p>";
        echo "Degree received date " . $row["prevEduReceivedDate"] . "<p>";
      }
    }
    else {
      echo "Not Applicable";
    }

    echo "</div>";
    echo "<div id='spacing'></div><div id='table'>";
    echo "<h2>Employment History</h2>";
    $job = "SELECT * FROM job, employment WHERE newAppID = $appID AND employment.jobTitle = job.jobTitle 
    AND employment.empName = job.empName";
    $jobResult = mysqli_query($conn, $job);
    if (mysqli_num_rows($jobResult) > 0) {
      while ($row = mysqli_fetch_assoc($jobResult)) {
        echo "Employer/Organization " . $row["empName"] . "<p>";
        echo "Are you currently employed at this organization? " . $row["jobCurrent"] . "<p>";
      }
    }
    else {
      echo "Not Applicable";
    }

    $employer = "SELECT * FROM employment, employer WHERE employment.newAppID = $appID 
    AND employment.empName = employer.empName";
    $empResult = mysqli_query($conn, $employer);
    if (mysqli_num_rows($empResult) > 0) {
      while ($row = mysqli_fetch_assoc($empResult)) {
        echo "Organization address " . $row["empStreetAddress"] . " " . $row["empCity"] . " ";
      }
    }

    $employerState = "SELECT stateName FROM employment, employer, state WHERE employment.newAppID = $appID AND employment.empName = employer.empName AND employer.empState = state.stateCode";
    $empStaResult = mysqli_query($conn, $employerState);
    if (mysqli_num_rows($empStaResult) > 0) {
      while ($row = mysqli_fetch_assoc($empStaResult)) {
        echo $row["stateName"] . " ";
      }
    }

    $empResult = mysqli_query($conn, $employer);
    if (mysqli_num_rows($empResult) > 0) {
      while ($row = mysqli_fetch_assoc($empResult)) {
        echo $row["empZipCode"] . "<p>";
        echo "Organization phone " . $row["empPhone"] . "<p>";
      }
    }

    $jobResult = mysqli_query($conn, $job);
    if (mysqli_num_rows($jobResult) > 0) {
      while ($row = mysqli_fetch_assoc($jobResult)) {
        echo "Start date (month and year) " . $row["jobStartMonth"] . "/" . $row["jobStartYear"] . "<p>";
        echo "End date (month and year) " . $row["jobEndMonth"] . "/" . $row["jobEndYear"] . "<p>";
        echo "Part-time or Full-time " . $row["jobFTPT"] . "<p>";
      }
    } 
    

    echo "</div>";
    echo "<div id='spacing'></div><div id='table'>";
    echo "<h2>Entrance Tests</h2>";
    $test = "SELECT entrTestDescription FROM exam, entranceTests WHERE exam.newAppID = $appID AND exam.entrTestCode = entranceTests.entrTestCode";
    $testResult = mysqli_query($conn, $test);
    if (mysqli_num_rows($testResult) > 0) {
      while ($row = mysqli_fetch_assoc($testResult)) {
        echo "Test type " . $row["entrTestDescription"] . "<p>";
      }
    }

    $testDate = "SELECT * FROM exam WHERE newAppID = $appID";
    $testDateResult = mysqli_query($conn, $testDate);
    if (mysqli_num_rows($testDateResult) > 0) {
      while ($row = mysqli_fetch_assoc($testDateResult)) {
        echo "Test Date (month and year)<br /> " . $row["examMonth"] . "/" . $row["examYear"] . "<p>";
      }
    }

    echo "</div>";

    mysqli_close($conn);
  ?>

  <div id="spacing"></div>
  <form action="applicationsRetrieve.php">
  <input type="submit" value="Go Back to My Applications">
  </form>
</div>
  </body>
</html>