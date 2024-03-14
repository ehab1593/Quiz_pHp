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
if ($_GET) {
  $quizdata = getQuizData($_GET['quiz_id'], getLink());
  $_SESSION['selected_quiz'] = $_GET['quiz_id'];
  $question_number = $quizdata[0]['question_id'];
  $questions = array();
  $answers = array();
  
  foreach($quizdata as $data) {
    if($data['question_id'] == $question_number) {
      array_push($answers, $data);
    } else {
      $question_number = $data['question_id'];
      array_push($questions, $answers);
      $answers = array();
      array_push($answers, $data);
    }
  }
  array_push($questions, $answers);
}
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz</title>
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
    
    <form action="result.php" method="post">
      <div class="container">
        <?php foreach($questions as $question) { ?>
          <div class="row questionRow">
            <div class="col-8">
              <h6 class="successtext"><?php echo $question[0]['question']; ?></h6>
                <?php foreach($question as $answer) { ?>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="<?php echo $answer['a_id'] ?>" name="question[<?php echo $answer['question_id'] ?>]" class="custom-control-input" value="<?php echo $answer['a_id'] ?>" required>
                    <label class="custom-control-label" for="<?php echo $answer['a_id'] ?>"><?php echo $answer['answer'] ?></label>
                  </div>
                <?php } ?>
              </div>
            </div>
        <?php } ?>
        <div class="row">
          <div class="col-8">
            <div class="form-group">
              <input type="submit" class="btn btn-sm btn-outline-success" value="Submit">
            </div>
          </div>
        </div>
      </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>

  </html>