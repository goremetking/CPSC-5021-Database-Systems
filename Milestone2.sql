/*
Begin by dropping all tables if they exist
*/

DROP TABLE IF EXISTS personalInfo;
DROP TABLE IF EXISTS employment;
DROP TABLE IF EXISTS employer;
DROP TABLE IF EXISTS job;
DROP TABLE IF EXISTS applicationInfo;
DROP TABLE IF EXISTS personalInfoEthnicity;
DROP TABLE IF EXISTS previousEducation;
DROP TABLE IF EXISTS exam;
DROP TABLE IF EXISTS ethnicity;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS newApplication;
DROP TABLE IF EXISTS studentType;
DROP TABLE IF EXISTS degree;
DROP TABLE IF EXISTS college;
DROP TABLE IF EXISTS major;
DROP TABLE IF EXISTS term;
DROP TABLE IF EXISTS entranceTests;
DROP TABLE IF EXISTS militaryBranch;
DROP TABLE IF EXISTS veteran;
DROP TABLE IF EXISTS state;
DROP TABLE IF EXISTS studentUser;

/*
Create reference tables to hold the information
for ID codes
*/

CREATE TABLE studentType (
	stuTypeCode int,
	stuTypeName varchar(30),
	PRIMARY KEY (stuTypeCode)
) ENGINE = InnoDB;

CREATE TABLE veteran(
	vetStatusID int NOT NULL,
	vetStatus varchar(20) NOT NULL,
	PRIMARY KEY (vetStatusID)
) ENGINE=InnoDB;

CREATE TABLE militaryBranch (
	milBranchID int,
	milBranchName varchar(20) NOT NULL,
	PRIMARY KEY (milBranchID)
) ENGINE=InnoDB;

CREATE TABLE degree (
	degCode int,
	degType varchar(15) NOT NULL,
	PRIMARY KEY (degCode)
) ENGINE=InnoDB;


CREATE TABLE major (
	majCode int,
	majName varchar(50) NOT NULL,
	PRIMARY KEY (majCode)
) ENGINE=InnoDB;


CREATE TABLE college (
	collCode int,
	collName varchar(35),
	PRIMARY KEY (collCode)
) ENGINE=InnoDB;

CREATE TABLE term (
	termCode int NOT NULL,
	termName varchar(20) NOT NULL,
	termStart date NOT NULL,
	PRIMARY KEY (termCode)
	) ENGINE=InnoDB;

CREATE TABLE state (
	stateCode int,
	stateName char(2),
	PRIMARY KEY (stateCode)
) ENGINE=InnoDB;

/*
Create all other tables
*/
CREATE TABLE studentUser(
	userName varchar(16), 
	password varchar(32),
	PRIMARY KEY(userName)
) ENGINE=InnoDB;

CREATE TABLE newApplication (
	newAppID int NOT NULL AUTO_INCREMENT,
	newAppDate timestamp default current_timestamp,
	stuTypeCode int,
	vetStatusID int,
	milBranchID int,
	degCode int,
	majCode int,
	collCode int,
	termCode int,
	userName varchar(16),
	PRIMARY KEY (newAppID),
	FOREIGN KEY (stuTypeCode) REFERENCES studentType (stuTypeCode) ON UPDATE CASCADE,
	FOREIGN KEY (vetStatusID) REFERENCES veteran (vetStatusID) ON UPDATE CASCADE,
	FOREIGN KEY (degCode) REFERENCES degree (degCode) ON UPDATE CASCADE,
	FOREIGN KEY (majCode) REFERENCES major (majCode) ON UPDATE CASCADE,
	FOREIGN KEY (collCode) REFERENCES college (collCode) ON UPDATE CASCADE,
	FOREIGN KEY (termCode) REFERENCES term(termCode) ON UPDATE CASCADE,
	FOREIGN KEY (milBranchID) REFERENCES militaryBranch(milBranchID) ON UPDATE CASCADE,
	FOREIGN KEY (userName) REFERENCES studentUser(userName) 
	/*Had some issues with on update cascade as that makes it difficult to add multiple user names into this table, so do not update cascade this.*/
) ENGINE=InnoDB;


CREATE TABLE personalInfo(
	perInTempID int NOT NULL AUTO_INCREMENT,
	perInFName varchar(25) NOT NULL,
	perInLName varchar(25) NOT NULL,
	perInPrefName varchar(25),
	perInDOB date,
	perInPhoneNum char(10),
	perInStAddress varchar(30),
	perInCity varchar(30),
	perInState int,
	locZipCode char(5), 
	perInUSCitizen varchar(3) NOT NULL,
	perInEngNative varchar(3) NOT NULL,
	perInGender varchar(6) NOT NULL,
	newAppID int NOT NULL,
	PRIMARY KEY (perInTempID),
	FOREIGN KEY (newAppID) REFERENCES newApplication (newAppID)
) ENGINE=InnoDB;

ALTER TABLE personalInfo 
	ADD FOREIGN KEY (perInState)
	REFERENCES state (stateCode);

CREATE TABLE ethnicity (
	ethnCode int,
	ethnType varchar(35) NOT NULL,
	PRIMARY KEY (ethnCode)
) ENGINE=InnoDB;


CREATE TABLE personalInfoEthnicity (
	newAppID int,
	ethnCode int,
	perInEthnHispLatOrigin varchar(3) NOT NULL,
	PRIMARY KEY (newAppID, ethnCode)
) ENGINE=InnoDB;


ALTER TABLE personalInfoEthnicity 
	ADD FOREIGN KEY (newAppID)
	REFERENCES newApplication (newAppID) ON DELETE CASCADE;
ALTER TABLE personalInfoEthnicity
	ADD FOREIGN KEY (ethnCode)
	REFERENCES ethnicity (ethnCode);


CREATE TABLE applicationInfo (
	newAppID int,
	appInFinAid varchar(3) NOT NULL,
	appInTuitAsst varchar(3) NOT NULL,
	appInOthPgrms varchar(3) NOT NULL,
	appInConvicted varchar(3) NOT NULL,
	appInProbSusp varchar(3) NOT NULL,
	PRIMARY KEY (newAppID),
	FOREIGN KEY (newAppID) REFERENCES newApplication (newAppID) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE employer (
	empName varchar(25),
	empStreetAddress varchar(10),
	empCity varchar(10),
	empState int,
	empZipCode char(5),
	empPhone char(10),
	PRIMARY KEY (empName)
) ENGINE=InnoDB;

ALTER TABLE employer 
	ADD FOREIGN KEY (empState)
	REFERENCES state (stateCode);

CREATE TABLE job (
	jobTitle varchar(15),
	jobFTPT char(2),
	jobStartMonth int,
	jobStartYear int,
	jobEndMonth int,
	jobEndYear int,
	jobCurrent varchar(3),
	empName varchar(25),
	PRIMARY KEY (jobTitle)
) ENGINE=InnoDB;


CREATE TABLE employment (
	empName varchar(25),
	jobTitle varchar(15),
	newAppID int,
	PRIMARY KEY (empName, jobTitle)
) ENGINE=InnoDB;


/*
Alter tables to add foreign keys to tables that have
more than one primary key, maintaining referential integrity
*/

ALTER TABLE employment
	ADD FOREIGN KEY (newAppID)
	REFERENCES newApplication (newAppID) ON DELETE CASCADE;
ALTER TABLE employment
	ADD FOREIGN KEY (empName)
	REFERENCES employer (empName) ON DELETE CASCADE;
ALTER TABLE employment 
	ADD FOREIGN KEY (jobTitle)
	REFERENCES job (jobTitle) ON DELETE CASCADE;


CREATE TABLE previousEducation (
	prevEduInstitution varchar(15),
	prevEduDegree varchar(10),
	prevEduMajor varchar(10),
	prevEduStart date NOT NULL,
	prevEduEnd date,
	prevEduReceivedDate date,
	newAppID int,
	PRIMARY KEY (prevEduInstitution, prevEduDegree, prevEduMajor),
	FOREIGN KEY (newAppID) REFERENCES newApplication(newAppID)
) ENGINE=InnoDB;

ALTER TABLE previousEducation
	ADD FOREIGN KEY (newAppID)
	REFERENCES newApplication (newAppID) ON DELETE CASCADE;

CREATE TABLE entranceTests (
	entrTestCode int,
	entrTestDescription varchar(15),
	PRIMARY KEY (entrTestCode)
) ENGINE=InnoDB;

CREATE TABLE exam (
	newAppID int,
	entrTestCode int,
	examMonth int,
	examYear int,
	PRIMARY KEY (newAppID, entrTestCode)
) ENGINE = InnoDB;

ALTER TABLE exam
	ADD FOREIGN KEY (newAppID)
	REFERENCES newApplication (newAppID) ON DELETE CASCADE;
ALTER TABLE exam
	ADD FOREIGN KEY (entrTestCode)
	REFERENCES entranceTests (entrTestCode);

/*
Insert bullet point data into the reference tables
and assign them an ID code to reference to.
*/

INSERT INTO veteran(vetStatusID, vetStatus) VALUES
	(0, 'Not a veteran'),
	(1, 'Currently Serving'),
	(2, 'Previously Served'),
	(3, 'Current Dependent');


INSERT INTO studentType (stuTypeCode, stuTypeName) VALUES
	(0, 'Graduate'),
	(1, 'Graduate Non-Matriculated'),
	(2, 'Graduate Readmission');


INSERT INTO militaryBranch (milBranchID, milBranchName) VALUES
	(0, 'Not Applicable'),
	(1, 'Army'),
	(2, 'Marine Corp'),
	(3, 'Navy'),
	(4, 'Air Force'),
	(5, 'Coast Guard');


INSERT INTO ethnicity (ethnCode, ethnType) VALUES
	(0, 'Asian'),
	(1, 'Black/African American'),
	(2, 'Native Hawaiian/Pacific Islander'),
	(3, 'Native America/Native Indian'),
	(4, 'White/Middle Eastern');


INSERT INTO degree (degCode, degType) VALUES
	(0, 'Certificates'),
	(1, "Master's");


INSERT INTO major (majCode, majName) VALUES
	(0, 'Certificate in Computer Science Fundamentals'),
	(1, 'Certificate in Software Architecture and Design'),
	(2, 'Certificate in Software Project Management');


INSERT INTO college (collCode, collName) VALUES
	(0, 'College of Science and Engineering'),
	(1, 'Albers School of Business'),
	(2, 'College of Arts and Sciences'),
	(3, 'College of Education'),
	(4, 'College of Nursing'),
	(5, 'School of Theology and Ministry');


INSERT INTO term (termCode, termName, termStart) VALUES
	(0, 'Summer 2016', '2016-06-08'),
	(1, 'Fall 2016', '2016-09-21'),
	(2, 'Summer 2017', '2017-06-13'),
	(3, 'Fall 2017', '2017-09-23');

INSERT INTO entranceTests (entrTestCode, entrTestDescription) VALUES
	(0, 'Not Applicable'),
	(1, 'CBEST'),
	(2, 'GMAT'),
	(3, 'GRE General'),
	(4, 'IELTS'),
	(5, 'MAT'),
	(6, 'PRAXIS'),
	(7, 'TOEFL'),
	(8, 'WEST-B'),
	(9, 'WEST-E');

INSERT INTO state (stateCode, stateName) VALUES
	(0, 'AL'),
	(1, 'AK'),
	(2, 'AZ'),
	(3, 'AR'),
	(4, 'CA'),
	(5, 'CO'),
	(6, 'CT'),
	(7, 'DE'),
	(8, 'FL'),
	(9, 'GA'),
	(10, 'HI'),
	(11, 'ID'),
	(12, 'IL'),
	(13, 'IN'),
	(14, 'IA'),
	(15, 'KS'),
	(16, 'KY'),
	(17, 'LA'),
	(18, 'ME'),
	(19, 'MD'),
	(20, 'MA'),
	(21, 'MI'),
	(22, 'MN'),
	(23, 'MS'),
	(24, 'MO'),
	(25, 'MT'),
	(26, 'NE'),
	(27, 'NV'),
	(28, 'NH'),
	(30, 'NJ'),
	(31, 'NM'),
	(32, 'NY'),
	(33, 'NC'),
	(34, 'ND'),
	(35, 'OH'),
	(36, 'OK'),
	(37, 'OR'),
	(38, 'PA'),
	(39, 'RI'),
	(40, 'SC'),
	(41, 'SD'),
	(42, 'TN'),
	(43, 'TX'),
	(44, 'UT'),
	(45, 'VT'),
	(46, 'VA'),
	(47, 'WA'),
	(48, 'WV'),
	(49, 'WI'),
	(50, 'WY');