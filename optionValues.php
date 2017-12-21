<?php
/*
Selects the values from the mySQL database to populate dropdown menus
@columnName is the column to SELECT, such as stuTypeName, milBranchName, ethnType, etc
@tableName is the table to SELECT FROM, such as the reference tables for relational integrity
*/

function optionVal($columnName, $tableName) { 

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

  $sql = "SELECT $columnName FROM $tableName";
  $result = mysqli_query($conn, $sql);


 if (mysqli_num_rows($result) > 0) {
  echo "&nbsp;&nbsp;<select name=$tableName>";
    echo "<option>--</option>";
  $count = 0; 

  while($row = mysqli_fetch_row($result)) {
    for ($i = 0; $i < mysqli_num_fields($result); $i++) { 
     echo "<option value ='" . $count . "'>" . $row[$i] . "</option>";
     $count++;
    }
  }
  echo "</select>"; 
} 

else {
  echo "0 results";
}

// Free result set
mysqli_free_result($result);
mysqli_close($conn);
}
?>