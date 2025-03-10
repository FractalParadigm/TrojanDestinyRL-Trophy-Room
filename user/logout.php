<?php
session_start();

// Unset session variables
$_SESSION = array();

// Destory the cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();


// Function from StackOverflow used to get the base URL, to which we append
// the redirect (where the user came from)
function url(){
    return sprintf(
      "%s://%s/%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_GET["redirect"]
    );
  }

  echo "
<script>window.location.href = \"" . url() . "\";</script>  
  ";
  
?>