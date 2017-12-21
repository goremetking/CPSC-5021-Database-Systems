<?php
  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

    $sql = "SELECT ethnType FROM ethnicity";
    $result = mysqli_query($conn, $sql);


   if (mysqli_num_rows($result) > 0) {
   	$count = 0;
   	echo "&nbsp;&nbsp;";
    while($row = mysqli_fetch_row($result)) {
      for ($i = 0; $i < mysqli_num_fields($result); $i++) { 
        echo "&nbsp;&nbsp;<input type=checkbox name=ethnicity[] value='". $count ."' />" . $row[$i] . "&nbsp;&nbsp;"; 
        $count++;
      }
    }
  } 

  else {
    echo "0 results";
  }

  // Free result set
  mysqli_free_result($result);
  mysqli_close($conn);
?>
