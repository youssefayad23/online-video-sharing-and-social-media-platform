<?php

require_once '../controllers/config.php';
require_once '../models/user.php';

error_reporting(0);

session_start();

$user = new User();

if (isset($_SESSION['userName'])) {
   header("Location: index.php");
}


//********************* 

// User registration

//********************* 


if (isset($_POST['submit'])) {
	$userName = $_POST['userName'];
	$email = $_POST['email'];
	$birthday = $_POST['birthday'];
	$password = md5($_POST['password']);
	$confirmPassword = md5($_POST['confirmPassword']);
   

	if ($password == $confirmPassword) {
		$sql = "SELECT * FROM user WHERE email='$email'";
		$result = mysqli_query($con, $sql);
		if (!$result->num_rows > 0) {
		
         
         $result = $user->addUser($userName, $email, $birthday, $password, $con);
			if ($result) {
				echo "<script>alert('Wow! User Registration Completed.')</script>";
				$userName = "";
				$email = "";
				$_POST['birthday'] = "";
				$_POST['password'] = "";
				$_POST['confirmPassword'] = "";
            header('location: index.php');
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}
		} else {
			echo "<script>alert('Woops! Email Already Exists.')</script>";
		}
		
	} else {
		echo "<script>alert('Password Not Matched.')</script>";
	}
}

//********************* 

// 

//********************* 

?>

<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>VIDOE - Video Streaming Website HTML Template</title>
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="post-login/img/favicon.png">
      <!-- Bootstrap core CSS-->
      <link href="post-login/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom fonts for this template-->
      <link href="post-login/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      <link href="post-login/css/osahan.css" rel="stylesheet">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="post-login/vendor/owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="post-login/vendor/owl-carousel/owl.theme.css">
   </head>
   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters">
               <div class="col-md-5 p-5 bg-white full-height">
                  <div class="login-main-left">
                     <div class="text-center mb-5 login-main-left-header pt-4">
                        <img src="post-login/img/favicon.png" class="img-fluid" alt="LOGO">
                        <h5 class="mt-3 mb-3">Welcome to Vidoe</h5>
                        <p>It is a long established fact that a reader <br> will be distracted by the readable.</p>
                     </div>
                     <form method="post" action="">
                        <div class="form-group">
                           <label>Username</label>
                           <input type="text" name="userName" class="form-control" value="<?php echo $userName;?>" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                           <div class="form-group">
                              <label>E-mail</label>
                              <input type="email" name="email" class="form-control" value="<?php echo $email;?>" placeholder="E-mail">
                           </div>
                           <div class="form-group">
                              <label>Birth Date</label>
                              <input type="date" name="birthday" value="<?php echo $_POST['birthday'];?>" class="form-control" placeholder="" required>
                           </div>
                           <label>Password</label>
                           <input type="password" name="password" value="<?php echo $_POST['password'];?>" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                           <label>Confirm password</label>
                           <input type="password" name="confirmPassword"  class="form-control" placeholder="Confirm password" required>
                        </div>
                        <div class="mt-4">
                           <button type="submit" name="submit" class="btn btn-outline-primary btn-block btn-lg">Sign Up</button>
                        </div>
                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray">Already have an Account? <a href="index.php">Sign In</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="login-main-right bg-white p-5 mt-5 mb-5">
                     <div class="owl-carousel owl-carousel-login">
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="post-login/img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">​Watch videos offline</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="post-login/img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Download videos effortlessly</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="post-login/img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Create GIFs</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Bootstrap core JavaScript-->
      <script src="post-login/vendor/jquery/jquery.min.js"></script>
      <script src="post-login/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="post-login/vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="post-login/vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="post-login/js/custom.js"></script>
   </body>
</html>