<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="../../styles/db_management.css" />
  <!-- <script src="trojan.js"></script>-->
  <title>TROJAN'S GENERAL DATA SHIT</title>
</head>

<body class="sqlOutput">
  <?php

  include("../dev_db_config.php"); // Include credentials
  
  try {  // Try opening the SQL database connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Database connection successful!</p>";
    echo "<p>If you're still having issues, talk to your system administrator, or file an issue with the package maintainer</p>";
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  ?>
</body>

</html>