<?php
define('DB_SERVER', '127.0.0.1:51280');
define('DB_USERNAME', 'azure');
define('DB_PASSWORD', '6#vWHD_$');
define('DB_NAME', 'localdb');

function getLink() {
  /* Connection to MySQL database */
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  return $link;
}
?>
