<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="../../styles/db_management.css" />
  <!-- <script src="trojan.js"></script>-->
  <title>no title</title>
</head>

<body class="sqlOutput">
  <?php
  // USER-DEFINED VARIABLES
  include("../db_config.php"); // Include database stuff


  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connected successfully</p>";
  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  //////////  USER DATA  ///////////

  // Check if the users table exists already
  $sqlCheckUserTable = $conn->prepare("SHOW TABLES LIKE '" . $userTableName . "'");

  // Run the query
  $sqlCheckUserTable->execute();

  //Check if any rows exist - if not, create the table, if yes, destroy it first, then create it
  $count = $sqlCheckUserTable->rowCount();

  if ($count != 0) {
    echo "<p>Deleting exsiting table '" . $userTableName . "'...</p>";
    // Create the query to drop the table
    $sqlDropUserTable = "DROP TABLE " . $userTableName;
    $conn->exec($sqlDropUserTable); // drop the table
    echo "<p>Deleted!</p><p>Creating new table '" . $userTableName . "'...</p>";
    try { // Create the new table
      $conn->query($sqlCreateUserTable);
      echo "<p>Table '" . $userTableName . "' successfully created (user data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateUserTable . "<br>" . $e->getMessage();
    }
  } else { // If the table doesn't already exist, we'll just create it
    try {
      $conn->query($sqlCreateUserTable);
      echo "<p>Table '" . $userTableName . "' successfully created (user data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateUserTable . "<br>" . $e->getMessage();
    }
  }

  // Next we're going to copy any safe admins into the users table.
  // This will make userlists easier to work with
  echo "<p>Copying users from safe admins...</p>";
  $copyAdmins = $conn->prepare("INSERT INTO " . $userTableName . " SELECT * FROM " . $adminUserTableName);

  $copyAdmins->execute();
  echo "<p>Copied!</p>";


  ////////  GAME DATA  ////////  

  // Check if the replay data table exists already
  $sqlCheckDataTable = $conn->prepare("SHOW TABLES LIKE '" . $gameDataTableName . "'");

  // Run the query
  $sqlCheckDataTable->execute();

  //Check if any rows exist - if not, create the table, if yes, destroy it first, then create it
  $count = $sqlCheckDataTable->rowCount();

  if ($count != 0) {
    echo "<p>Deleting exsiting table '" . $gameDataTableName . "'...</p>";
    // Create the query to drop the table
    $sqlDropDataTable = "DROP TABLE " . $gameDataTableName;
    $conn->exec($sqlDropDataTable); // drop the table
    echo "<p>Deleted!</p><p>Creating new table '" . $gameDataTableName . "'...</p>";
    try { // Create the new table
      $conn->query($sqlCreateDataTable);
      echo "<p>Table '" . $gameDataTableName . "' successfully created (saved game data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateDataTable . "<br>" . $e->getMessage();
    }
  } else { // If the table doesn't already exist, we'll just create it
    try {
      $conn->query($sqlCreateDataTable);
      echo "<p>Table '" . $gameDataTableName . "' successfully created (saved game data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateDataTable . "<br>" . $e->getMessage();
    }
  }

  ////////  TOURNAMENT DATA  ////////
  
  
  // Check if the replay data table exists already
  $sqlCheckTournamentTable = $conn->prepare("SHOW TABLES LIKE '" . $tournamentDataTableName . "'");

  // Run the query
  $sqlCheckTournamentTable->execute();

  //Check if any rows exist - if not, create the table, if yes, destroy it first, then create it
  $count = $sqlCheckTournamentTable->rowCount();

  if ($count != 0) {
    echo "<p>Deleting exsiting table '" . $tournamentDataTableName . "'...</p>";
    // Create the query to drop the table
    $sqlDropTournamentTable = "DROP TABLE " . $tournamentDataTableName;
    $conn->exec($sqlDropTournamentTable); // drop the table
    echo "<p>Deleted!</p><p>Creating new table '" . $tournamentDataTableName . "'...</p>";
    try { // Create the new table
      $conn->query($sqlCreateTournamentTable);
      echo "<p>Table '" . $tournamentDataTableName . "' successfully created (tournament data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateTournamentTable . "<br>" . $e->getMessage();
    }
  } else { // If the table doesn't already exist, we'll just create it
    try {
      $conn->query($sqlCreateTournamentTable);
      echo "<p>Table '" . $tournamentDataTableName . "' successfully created (tournament data)</p>";
    } catch (PDOException $e) {
      echo $sqlCreateTournamentTable . "<br>" . $e->getMessage();
    }
  }

  $conn = null; // Close the connection

  // Tell the user we're done
  echo "<p style=\"font-weight:bold\">DONE!</p>";

  ?>

</body>

</html>