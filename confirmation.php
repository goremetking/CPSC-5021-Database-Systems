<html>
<head>
  <title>Application Confirmation</title>
  <link href="styles.css" type="text/css" rel="stylesheet" />


  <?php
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    session_start();
    $appID = $_SESSION['applicationID'];
    extract($_REQUEST, EXTR_SKIP);

    $sql00 = mysqli_prepare($conn, "INSERT INTO applicationInfo (newAppID, appInFinAid, appInTuitAsst, appInOthPgrms, appInConvicted, appInProbSusp) VALUES    (?,?,?,?,?,?)");
    mysqli_stmt_bind_param($sql00, "isssss", $appID, $appInFinAid, $appInTuitAsst, $appInOthPgrms, $appInConvicted, $appInProbSusp);

    $sql01 = mysqli_prepare($conn, "INSERT INTO previousEducation (newAppID, prevEduInstitution, prevEduDegree, prevEduMajor, prevEduStart, prevEduEnd, prevEduReceivedDate) VALUES (?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($sql01, "issssss", $appID, $prevEduInstitution, $prevEduDegree, $prevEduMajor, $prevEduStart, $prevEduEnd, $prevEduReceivedDate);

    $sql02 = mysqli_prepare($conn, "INSERT INTO employment VALUES (?,?,?)");
    mysqli_stmt_bind_param($sql02, "ssi", $empName, $jobTitle, $appID);

    $sql03 = mysqli_prepare($conn, "INSERT INTO employer (empName, empStreetAddress, empCity, empState, empZipCode, empPhone) VALUES (?,?,?,?,?,?)");
    mysqli_stmt_bind_param($sql03, "sssiss", $empName, $empStreetAddress, $empCity, $state, $empZipCode, $empPhone);

    $sql04 = mysqli_prepare($conn, "INSERT INTO job (jobTitle, jobFTPT, jobStartMonth, jobStartYear, jobEndMonth, jobEndYear, jobCurrent, empName) VALUES (?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($sql04, "ssiiiiss", $jobTitle, $jobFTPT, $jobStartMonth, $jobStartYear, $jobEndMonth, $jobEndYear, $jobCurrent, $empName);

    $sql05 = mysqli_prepare($conn, "INSERT INTO exam (newAppId, entrTestCode, examMonth, examYear) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($sql05, "iiii", $appID, $entranceTests, $examMonth, $examYear);

    mysqli_stmt_execute($sql00);
    mysqli_stmt_close($sql00);
    mysqli_stmt_execute($sql01);
    mysqli_stmt_close($sql01);
    mysqli_stmt_execute($sql05);
    mysqli_stmt_close($sql05);

    mysqli_stmt_execute($sql03);
    mysqli_stmt_close($sql03);
    mysqli_stmt_execute($sql04);
    mysqli_stmt_close($sql04);
    mysqli_stmt_execute($sql02);
    mysqli_stmt_close($sql02);

    mysqli_close($conn);
  ?>

</head>

<body>
<!-- SELECT scripts to display application -->
    <div id="table">
    <h1>Application Submitted</h1>
    View application below:
    </div>
    <div id="spacing"></div>
    <?php
      include_once 'viewApplication.php';
    ?>

</body>
</html>
