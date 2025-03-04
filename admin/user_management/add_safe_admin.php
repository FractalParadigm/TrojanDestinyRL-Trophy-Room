<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/styles/db_management.css" />
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


    // Check if the users table exists already
    $sqlCheckUserTable = $conn->prepare("SHOW TABLES LIKE '" . $adminUserTableName . "'");
  
    // Run the query
    $sqlCheckUserTable->execute();
  
    //Check if any rows exist - if not, create the table
    $count = $sqlCheckUserTable->rowCount();

    if ($count == 0) {
      echo "<p>Admins table not found! Probably initial setup. Creating...</p>";
        try {
          $conn->query($sqlCreateAdminTable);
          echo "<p>Table '" . $adminUserTableName . "' successfully created (safe admins)</p>";
          echo "<p>After we finish creating your user, you will need to use the \"Initialize Databases\" option in the admin panel before you can begin to use your server</p>";
        } catch (PDOException $e) {
          echo $sqlCreateUserTable . "<br>" . $e->getMessage();
        }
    }
    

  // Variables for the various input fields
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Hash the password for security
  $discord = $_POST["discord"];
  $twitch = $_POST["twitch"];
  $youtube = $_POST["youtube"];

  // Gotta check and make sure the user we're creating is an admin
  $isAdmin = 0;

  if (filter_has_var(INPUT_POST, "isAdmin")) {
    $isAdmin = 1;
  }

  // Prepare the query
  $insert = $conn->prepare("INSERT INTO " . $adminUserTableName . " (username, password, discord, twitch, youtube, isAdmin) VALUES (:username, :password, :discord, :twitch, :youtube, :isAdmin)");

  // Bind parameters to the query
  $insert->bindParam(":username", $username);
  $insert->bindParam(":password", $password);
  $insert->bindParam(":discord", $discord);
  $insert->bindParam(":twitch", $twitch);
  $insert->bindParam(":youtube", $youtube);
  $insert->bindParam(":isAdmin", $isAdmin);

  // Execute
  $insert->execute();
  echo "Safe Admin created successfully!";

  } catch (PDOException $e) { // failed connection
    echo "Connection failed: " . $e->getMessage();
  }

  $conn = null;

  ?>

</body>

</html>