<?php
// DB LOGIN DETAILS HERE
// It is recommended you put your credentials in a separate file

$servername = "127.0.0.1";
$dbUsername = "USERNAME";
$dbPassword = "PASSWORD";
$dbName = "DBNAME";


/*////// USER-CONFIGURABLE VARIABLES HERE /////////
 
   I don't recommend you change these, but if you 
   know what you're doing, have at 'er

/////////////////////////////////////////////////*/


$userTableName = "users";  // name of the table containing user data
$gameDataTableName = "games"; // table containing replay data
$tournamentDataTableName = "tournaments"; // tournament data table
$adminUserTableName = "safeadmins";



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
privileges TINYINT(2),
username VARCHAR(30) NOT NULL,
password VARCHAR(255),
discord VARCHAR(50),
discordLink VARCHAR(150),
twitch VARCHAR(50),
youtube VARCHAR(50),
youtubeLink VARCHAR(150),
userCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
userUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


// USER DATA TABLE
$sqlCreateUserTable = "
CREATE TABLE " . $userTableName . " (
userID INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
privileges TINYINT(2),
username VARCHAR(30) NOT NULL,
password VARCHAR(255),
discord VARCHAR(50),
discordLink VARCHAR(150),
twitch VARCHAR(50),
youtube VARCHAR(50),
youtubeLink VARCHAR(150),
userCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
userUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


// GAME DATA TABLE
$sqlCreateDataTable = "
CREATE TABLE " . $gameDataTableName . " (
gameID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
gameName VARCHAR(100),
gameDate DATE,
uploadedBy VARCHAR(30),
uploadedByID INT(8) UNSIGNED,
numPlayers TINYINT UNSIGNED,
winningTeam VARCHAR(6),
blueTeamName VARCHAR(35),
blueScore INT(3),
orangeTeamName VARCHAR(35),
orangeScore INT(3),
bluePlayer1 VARCHAR(30),
bluePlayer2 VARCHAR(30),
bluePlayer3 VARCHAR(30),
bluePlayer4 VARCHAR(30),
orangePlayer1 VARCHAR(30),
orangePlayer2 VARCHAR(30),
orangePlayer3 VARCHAR(30),
orangePlayer4 VARCHAR(30),
tournamentName VARCHAR(150),
ballchasingID VARCHAR(50),
notes VARCHAR(1000),
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


// TOURNAMENT DATA TABLE
$sqlCreateTournamentTable = "
CREATE TABLE " . $tournamentDataTableName . " (
tournamentID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
tournamentName VARCHAR(150),
tournamentDate DATE,
tournamentDivision VARCHAR(20),
numPlayers TINYINT UNSIGNED,
bestOf TINYINT UNSIGNED,
winningTeamName VARCHAR(35),
winner1 VARCHAR(30),
winner2 VARCHAR(30),
winner3 VARCHAR(30),
winner4 VARCHAR(30),
notes VARCHAR(1000),
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


?>