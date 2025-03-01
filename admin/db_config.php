<?php
// DB LOGIN DETAILS HERE

$servername = "127.0.0.1";
$username = "USERNAME";
$password = "PASSWORD";
$dbName = "DBNAME";

////////////////////////////  DEVELOPER  ///////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
// THIS IS ONLY TO REPLACE THE ABOVE DEFAULTS WITH OUR DEV-ENVIRONMENT DETAILS
include ("dev_db_config.php");
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


/*////// USER-CONFIGURABLE VARIABLES HERE /////////
 
   I don't recommend you change these, but if you 
   know what you're doing, have at 'er

/////////////////////////////////////////////////*/


$userTableName = "users";  // name of the table containing user data
$dataTableName = "replays"; // table containing replay data
$trophyTableName = "trophies"; // trophy data table
$adminUserTableName = "safeadmins";

$passwordLength = 8;  // default minimum random password length  




////////////////////////////////////////////////////////////////////////////


/*///////  DATABASE-IMPORTANT STUFF  /////////

             !!!! WARNING !!!!
  DO NOT EDIT THE FOLLOWING UNLESS YOU ARE 
  ABSOLUTELY CERTAIN OF WHAT YOU ARE DOING    
   
////////////////////////////////////////////*/

// ADMIN DATA TABLE
$sqlCreateAdminTable = "
CREATE TABLE " . $adminUserTableName . " (
userID INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
isAdmin BOOL,
username VARCHAR(30) NOT NULL,
password VARCHAR(255),
discord VARCHAR(50),
twitch VARCHAR(50),
youtube VARCHAR(50),
userCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
userUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


// USER DATA TABLE
$sqlCreateUserTable = "
CREATE TABLE " . $userTableName . " (
userID INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
isAdmin BOOL,
username VARCHAR(30) NOT NULL,
password VARCHAR(255),
discord VARCHAR(50),
twitch VARCHAR(50),
youtube VARCHAR(50),
userCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
userUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


// REPLAYS DATA TABLE
$sqlCreateDataTable = "
CREATE TABLE " . $dataTableName . " (
replayID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
ballchasingID VARCHAR(100),
replayName VARCHAR(150),
uploadedBy VARCHAR(30),
numPlayers TINYINT UNSIGNED,
player1 VARCHAR(30),
player2 VARCHAR(30),
player3 VARCHAR(30),
player4 VARCHAR(30),
player5 VARCHAR(30),
player6 VARCHAR(30),
player7 VARCHAR(30),
player8 VARCHAR(30),
notes VARCHAR(1000)
)";


// TROPHY DATA TABLE
$sqlCreateTrophyTable = "
CREATE TABLE " . $trophyTableName . " (
trophyID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
replayID INT UNSIGNED,
trophyType VARCHAR(25),
winner1 VARCHAR(30),
winner2 VARCHAR(30),
winner3 VARCHAR(30),
numPlayers TINYINT UNSIGNED,
notes VARCHAR(1000)
)";
?>