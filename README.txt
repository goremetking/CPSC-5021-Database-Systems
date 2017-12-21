Milestone 4 CPSC5021-1 Database Systems: Michael Kung, Darsh Lin


//PREPARATION
1) The first thing you would want to do is create the needed tables which should be possible through the use of the file "Milestone2.sql" in mySQL.

2) Upon connecting to localhost, all the code is connected to the database "lind2' under the user 
"lind2" with password "4EKud*pu", if you would like to change the database, you would
have to modify the current files: 
personalInformation.php 
applicationInformation.php
viewApplication.php
checkboxValues.php
myApplications.php
newUser.php
optionValues.php
applicationsretrieve.php
confirmation.php

As you can tell, this website goes in and out of the database a lot as it is easier to control the design and dependencies that way.

3) Never ever hit the back button while going through all the pages unless you want to feel the wrath of khaaaaan! Or unless you want it to crash.

4) Also please be sure to fill in all the fields in every page as we haven't done page verification at all in the pages and it would lead to unexpected
errors.


//ACTUAL INTERACTION WITH WEBSITE STARTS HERE YOU CAN JUST SKIP TO THIS IF YOU WANT
1) The first file you want to go to is loginScreen.html, from there, there should be buttons to take you around to the right pages short of the back button. If you would rather sign in to an already made account, there is an already made account with username: "student1" and password "stu12345".

2) You would have to make an account first which inserts a username and MD5 password into the "studentUser" table. this is processed in the "newUser.php" file, it will have a button that will take you straight to the "My Applications" page which will process your information automatically in "myApplications.php". If however, you already have an account, it would just process your log in information in "myApplications.php" right away. This is done using prepared statements.

3) Clicking the button will take you to the "My Applications" page where you can create a new application. The "My Applications" page made under the "myApplications.php" file, however constructing the table is done under the "applicationsRetrieve.php" file. So when applications are made, the "applicationsRetrieve.php"file will be where it would run all the select statements for the files.

4) Upon completion of the "New Application" page, it will take you to the "personalInfo.php" file the process to insert the info into the "newApplication" table is actually located in the beginning of this file.

5) Once the "Personal Information" page is completed, it will take you to "applicationInformation.php" where it will insert all the fields to the database and
in the tables "personalInfo" and "personalInfoEthnicity" at the beginning of the "applicationInformation.php" file.

6) Now you should be in the "Application Information" upon completing everything on this page and hitting submit, it should do the insert to the "applicationInfo", "previousEducation", "employment", "employer", and "job" tables in the "confirmation.php" file which will then move on to the "viewApplication.php" file.

7) You should be in the "Confirmation" page at this point. The "viewApplication.php" is where the actual confirmation file select statements take place for both the confirmation after completing the applications and for viewing
them through the links in the "My Applications" page.
