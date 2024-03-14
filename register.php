<?php
// imports
require 'config.php';
require_once 'getdata.php';
require_once 'insertdata.php';
 
$student_id = $fname = $lname = $password = $confirm_password = "";
$student_id_err = $password_err = $confirm_password_err = "";
$is_admin = 0;

// check request method
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    
    // validate studentID, and check if it is already registered
    if(empty(trim($_POST["student_id"]))){
        $student_id_err = "Please enter your student id.";
    } else{
      if (getUserByID(trim($_POST['student_id']), getLink())) {
        $student_id_err = "This Student ID is already registered.";
      } else {
        $student_id = trim($_POST["student_id"]);
      }
    }
    
    // password validation
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must be at least 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password mismatch.';
        }
    }
    
    // insert new user to database
    if(empty($student_id_err) && empty($password_err) && empty($confirm_password_err)){
      $pass_hash = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      if (insertNewUser($student_id, $fname, $lname, $pass_hash, $is_admin, getLink())) {
        header("location: login.php");
      } else {
        echo "Database error, try later o/";
      }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container center-content">
      <div class="row justify-content-center">
        <div class="col-6">
          <h2>Sign Up</h2>
          <p>Please fill this form to create an account.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($student_id_err)) ? 'has-error' : ''; ?>">
                  <label>Student ID:<sup>*</sup></label>
                  <input type="text" name="student_id"class="form-control" value="<?php echo $student_id; ?>">
                  <span class="help-block"><?php echo $student_id_err; ?></span>
              </div>
              <div class="form-group">
                <label>Firstname:</label>
                <input type="text" name="fname" class="form-control">
              </div>
              <div class="form-group">
                <label>Lastname:</label>
                <input type="text" name="lname" class="form-control">
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>Password:<sup>*</sup></label>
                  <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                  <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>Confirm Password:<sup>*</sup></label>
                  <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                  <span class="help-block"><?php echo $confirm_password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-outline-success" value="Submit">
                  <input type="reset" class="btn btn-outline-warning" value="Reset">
              </div>
              <p>Already have an account? <a href="login.php">Login here</a>.</p>
          </form>
        </div>
      </div>
    </div>    
</body>
</html>