<?php
require 'getdata.php';
require 'config.php';
require 'deletedata.php';
session_start();

if(!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])){
  header("location: login.php");
  exit;
} else if($_SESSION['is_admin'] != 1) {
  header("location: overview.php");
}

if($_POST) {
  if($_POST['reset']) {
    resetStudentScore($_POST['quiz_id'], $_POST['student_id'], getLink());
  }
}
$scores = getAllStudentScores(getLink());
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz overview</title>
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
                <a class="dropdown-item" href="#">View results</a>
                <a class="dropdown-item" href="#">New quiz</a>
              </div>
            </li>
          <?php } ?>
          
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <span class="navbar-text mx-2">
              Logged in as <?php echo $_SESSION['fname'] . " " . $_SESSION['name'] . " (" . '<span class="successtext">' . $_SESSION['student_id'] . '</span>' . ")"; ?>
            </span>
          </li>
          <li class="nav-item navbutton">
            <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="page-header">
      <h1>Students' scores:</h1>
    </div>
    
    <table class="table table-sm table-hover text-left">
      <thead>
        <tr class="d-flex">
          <th class="col-2">NAME</th>
          <th class="col-6">STUDENT ID</th>
          <th class="col-2">QUIZ</th>
          <th class="col-1 text-right">SCORE</th>
          <th class="col-1 text-right">ACTIONS</th>
        </tr>
      </thead>
      <?php foreach($scores as $score) { 
        $success = false;
        if ($score['score'] > $score['n_questions'] / 2) {
          $success = true;
        }?>
        <tr class="d-flex">
          <td class="col-2"><?php echo $score['fname'] . ' ' . $score['lname']; ?></td>
          <td class="col-6"><?php echo $score['student_id']; ?></td>
          <td class="col-2"><?php echo $score['name']; ?></td>
          <td class="col-1 text-right <?php echo ($success) ? 'successtext' : 'failtext'; ?>"><?php echo $score['score'] . ' / ' . $score['n_questions']; ?></td>
          <td class="col-1 text-right">
            <form method="POST" action="">
              <input type="submit" class="btn btn-sm btn-outline-warning xs-btn" value="Reset" name="reset">
              <input type="hidden" name="quiz_id" value="<?php echo $score['quiz_id'];?>">
              <input type="hidden" name="student_id" value="<?php echo $score['student_id'];?>">
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>

  </body>
</html>