<?php
require_once 'config.php';
require_once 'getdata.php';
 
$student_id = $password = "";
$student_id_err = $password_err = "";
$is_admin = 0;
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if student_id is empty
    if(empty(trim($_POST["student_id"]))){
        $student_id_err = 'Please enter Student ID.';
    } else{
        $student_id = trim($_POST["student_id"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($student_id_err) && empty($password_err)){
      $user = getUserCredentials($student_id, getLink());
      if($user) {
        if(password_verify($password, $user['pass_hash'])) {
          session_start();
          $_SESSION['is_admin'] = $user['is_admin'];
          $_SESSION['student_id'] = $user['id'];
          $_SESSION['fname'] = $user['fname'];
          $_SESSION['lname'] = $user['lname'];
          header("location: overview.php");
        } else {
          $password_err = 'Invalid password.';
        }
      } else {
        $student_id_err = 'Student ID not found.';
      }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container center-content">
      <div class="row justify-content-center">
        <div class="col-6">
          <h2>Login</h2>
          <p>Please fill in your details inorder to login.</p>
		  
		  
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
             <div class="form-group <?php echo (!empty($student_id_err)) ? 'has-error' : ''; ?>">
              <label>Student ID:<sup>*</sup></label>
              <input type="text" name="student_id"class="form-control" value="<?php echo $student_id; ?>">
              <span class="help-block"><?php echo $student_id_err; ?></span>
			  </div>    
				
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                 <label>Password:<sup>*</sup></label>
                  <input type="password" name="password" class="form-control">
                  <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-outline-success" value="Login">
              </div>
              <p>OR: <a href="register.php">Sign up for the quiz</a>.</p>
          </form>
        </div>
      </div>
    </div>    
</body>
</html>