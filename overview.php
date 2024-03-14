<?php
require 'getdata.php';
require 'config.php';
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])){
  header("location: login.php");
  exit;
}
$quizzes = getOverviewData(getLink());
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz overview</title>
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:300,400" rel="stylesheet">
    <style type="text/css">
      body {
        text-align: center;
      }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand text-danger" href="#">Quiz</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Overview <span class="sr-only">(current)</span></a>
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

    <div class="page-header">
      <h1>All quizzes:</h1>
    </div>
    <div class="list-group">
      <?php foreach($quizzes as $q) { ?>
        <div class="list-group-item list-group-item-action">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-1 text-left">
                <?php if($q['score'] > $q['n_questions'] / 2) { ?>
                  <i class="material-icons green">mood</i>
                <?php } else if(!isset($q['score'])) { ?>
                  <i class="material-icons">sentiment_neutral</i>
                <?php } else { ?>
                  <i class="material-icons red">mood_bad</i>
                <?php } ?>
              </div>

              <div class="col-8 text-left">
                <?php echo $q['name'] ?>
              </div>

              <div class="col-1 text-right">
                <?php echo $q['score'] . ' / ' . $q['n_questions'] ?>
              </div>

              <div class="col-1 text-left">
                <?php if($q['score'] > $q['n_questions'] / 2) {
                        echo '<span style="color: #afff6d;">Pass</span>';
                      } else if(!isset($q['score'])) {
                        echo 'Undone';
                      } else {
                        echo '<span style="color: #ff826d;">Fail</span>';
                      } ?>
              </div>

              <div class="col-1 text-right">
                <?php if(!isset($q['score'])) {
                  echo '<a href="quiz.php?quiz_id=' . $q['id'] . '"' . ' class="btn btn-sm xs-btn btn-outline-success">Start</a>';
                } ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <p>
      <?php echo phpversion(); ?>
    </p>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>

  </html>
