<?php
include_once '../../controllers/config.php';
include_once '../../controllers/displayer.php';
include_once '../../models/user.php';
include_once '../../models/video.php';
include_once '../../models/channel.php';

if (!isset($_SESSION['userName'])) {
   header("Location: ../index.php");
}
$user = new User();
$video = new Video();
$channel = new Channel();

if (isset($_POST['but_upload'])) {
   $maxsize = 104857600; // 100MB
   if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
      $name = $_FILES['file']['name'];
      $title = $_POST['name'];
      $target_dir = "videos/";
      $target_file = $target_dir . $_FILES["file"]["name"];
      $description = $_POST['description'];
      // Select file type
      $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // Valid file extensions
      $extensions_arr = array("mp4", "avi", "3gp", "mov", "mpeg", "mkv");

      // Check extension
      if (in_array($extension, $extensions_arr)) {

         // Check file size
         if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
            $_SESSION['message'] = "File too large. File must be less than 100MB.";
         } else {
            // Upload
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
               // Insert record
               $video->uploadVideo($title, $description,  $target_file, $target_file, $channel->getChannelID($user->getUserID($_SESSION['email'], $con), $con), $con);
               echo "<script>alert('Upload successfully.')</script>";
            }
         }
      } else {
         echo "<script>alert('Invalid file extension.')</script>";
      }
   } else {
      echo "<script>alert('Please select a file.')</script>";
   }
   header('location: landing.php');
   exit;
}
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
   <link rel="icon" type="image/png" href="img/favicon.png">
   <!-- Bootstrap core CSS-->
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <!-- Custom fonts for this template-->
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <!-- Custom styles for this template-->
   <link href="css/osahan.css" rel="stylesheet">
   <!-- Owl Carousel -->
   <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
   <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
</head>

<body id="page-top">

   <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
      &nbsp;&nbsp;
      <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
         <i class="fas fa-bars"></i>
      </button> &nbsp;&nbsp;
      <a class="navbar-brand mr-1" href="index.php"><img class="img-fluid" alt="" src="img/logo.png"></a>
      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
         <div class="input-group">
            <div class="input-group-append">
               <a href="landing.php">
                  <button class="btn btn-light" type="button">
                     Search
                  </button>
               </a>
            </div>
         </div>
      </form>
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
         <?php

         displayNavBarUploadButton($user->getIsCreator($_SESSION['email'], $con));

         ?>
         <li class="nav-item dropdown no-arrow mx-1">

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another action</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star "></i> &nbsp; Something else here</a>
            </div>
         </li>
         <li class="nav-item dropdown no-arrow mx-1">

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another action</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star "></i> &nbsp; Something else here</a>
            </div>
         </li>
         <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
            <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <img alt="Avatar" src="https://www.seekpng.com/png/detail/413-4139803_unknown-profile-profile-picture-unknown.png">
               <?php echo $_SESSION['userName'] ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
               <a class="dropdown-item" href="account.php"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My
                  Account</a>

               <a class="dropdown-item" href="settings.php"><i class="fas fa-fw fa-cog"></i> &nbsp; Settings</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
            </div>
         </li>
      </ul>
   </nav>
   <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
         <li class="nav-item ">
            <a class="nav-link" href="landing.php">
               <i class="fas fa-fw fa-home"></i>
               <span>Home</span>
            </a>
         </li>
         <li class="nav-item active">
            <a class="nav-link" href="channels.php">
               <i class="fas fa-fw fa-users"></i>
               <span>Channels</span>
            </a>
         </li>


         <li class="nav-item">
            <a class="nav-link" href="playlists.php">
               <i class="fa fa-gamepad"></i>
               <span>Playlists</span>
            </a>
         </li>



         <?php

         displaySideBarChannelButtons($user->getIsCreator($_SESSION['email'], $con));

         ?>
      </ul>

      <div id="content-wrapper">
         <div class="container-fluid upload-details">
            <div class="row">
               <div class="col-lg-12">
                  <div class="main-title">
                     <h6>Upload Details</h6>
                  </div>
               </div>
               <form action method="post" action="" enctype='multipart/form-data'>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="osahan-form">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group" style="padding-left: 20px;">
                                    <label for="e1">Video Title</label>
                                    <input type="text" name="name" placeholder="Title" id="e1" class="form-control">
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="form-group" style="padding-left: 20px;">
                                    <label for="e2">Description</label>
                                    <textarea rows="3" id="e2" class="form-control" name="description" placeholder="Description"></textarea>
                                 </div>
                                 <div class="form-group" style="padding-left: 20px;">
                                    <label for="">Video <span>Your maximum file size is 100MBs</span></label><br>
                                    <input type="file" name="file" id="file" required="required" />
                                 </div>
                              </div>
                           </div>
                           <div class="row">

                              <div class="osahan-area text-center mt-3" style="padding-left:45%">
                                 <button class="btn btn-outline-primary" name="but_upload">Upload</button>
                              </div>
                              <hr>
               </form>
            </div>
         </div>
      </div>

   </div>
   <!-- /.content-wrapper -->
   </div>
   <!-- /#wrapper -->
   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
   </a>
   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
               <a class="btn btn-primary" href="../logout.php">Logout</a>
            </div>
         </div>
      </div>
   </div>
   <!-- Bootstrap core JavaScript-->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <!-- Core plugin JavaScript-->
   <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
   <!-- Owl Carousel -->
   <script src="vendor/owl-carousel/owl.carousel.js"></script>
   <!-- Custom scripts for all pages-->
   <script src="js/custom.js"></script>
</body>

</html>