<?php
require 'getdata.php';
require 'insertdata.php';
require 'config.php';
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])){
  header("location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome</title>
    <!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:300,400" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand text-danger" href="overview.php">Quiz</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="overview.php">Overview <span class="sr-only">(current)</span></a>
          </li>
          
          <?php if ($_SESSION['is_admin'] == 1) {?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Admin
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="adminview.php">View results</a>
                <a class="dropdown-item" href="#">New quiz</a>
              </div>
            </li>
          <?php } ?>
          
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <span class="navbar-text mx-2">
              Logged in as <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] . " (" . '<span class="successtext">' . $_SESSION['student_id'] . '</span>' . ")"; ?>
            </span>
          </li>
          <li class="nav-item navbutton">
            <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <?php
      if ($_SESSION['selected_quiz'] != null) {
        insertAnswer($_POST['question'], getLink());
        $rslt = getScore($_SESSION['student_id'], $_SESSION['selected_quiz'], getLink());
        insertScore($rslt, getLink());
        $_SESSION['selected_quiz'] = null;
      } else {
        echo "no quiz selected, null";
        $rslt = "-";
      }
    ?>
    
    <div class="card">
      <div class="card-header">
        RESULT:
      </div>
      <div class="card-body">
        <h5 class="card-title">Your score: <?php echo $rslt; ?></h5>
        <a href="overview.php" class="btn btn-sm btn-outline-success">Back to overview</a>
      </div>
    </div>
    
  </body>
</html>