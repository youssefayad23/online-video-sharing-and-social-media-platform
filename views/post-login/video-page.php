<?php
include_once '../../controllers/config.php';
include_once '../../controllers/displayer.php';
include_once '../../models/user.php';
include_once '../../models/video.php';
include_once '../../models/channel.php';
include_once '../../models/comment.php';

if (!isset($_SESSION['userName'])) {
   header("Location: ../index.php");
}

$user = new User();
$video = new Video();
$channel = new Channel();
$comment = new Comment();

$index1 = intval($_GET['videoIndex']);
$vidRow = $video->getVidInfo($index1, $con);
$_SESSION['videoLocation'] = $vidRow['location'];
$_SESSION['vidName'] = $vidRow['name'];
$_SESSION['about'] = $vidRow['description'];
$_SESSION['like'] = $vidRow['likes'];




//get channel id and name
//-----------------------
$channelID = $vidRow['channelID'];
$vidRow2 = $channel->getChannelInfo($vidRow['channelID'], $con);
$_SESSION['channelName'] = $vidRow2['channelName'];


if (isset($_GET['addComment']) && $_GET['comment'] != '') {


   $userID =  $user->getUserID($_SESSION['email'], $con);
   $index1 = $_GET['videoGetter'];
   $commentContent = $_GET['comment'];
   $comment->addComment($_GET['comment'], $userID, $con);
   $sql = "SELECT * from comment where content = '$commentContent'";
   $result = mysqli_query($con, $sql);
   $vidRow2 = mysqli_fetch_array($result);
   $commentID = $vidRow2['commentID'];
   $sql = "INSERT INTO commentids (videoID, commentID) VALUES ('$index1', '$commentID')";
   $result = mysqli_query($con, $sql);
   header("location: video-page.php?videoIndex=" . $index1 . "");
}




?>

<?php
//error_reporting(0);


if (isset($_POST['like'])) {

   $userid = $user->getUserID($_SESSION['email'], $con);
   $result3 = mysqli_query($con, "SELECT * FROM likedvideos WHERE userID='$userid' AND videoID='$index1'");
   if ($result3->num_rows > 0) {

      $video->unlike($userid, $index1, $con);

      header("location: video-page.php?videoIndex=" . $index1 . "");
   } else {

      $video->like($userid, $index1, $con);
      header("location: video-page.php?videoIndex=" . $index1 . "");
   }
}

if (!isset($_POST['subscribe'])) {
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
         <a class="navbar-brand mr-1" href="landing.php"><img class="img-fluid" alt="" src="img/logo.png"></a>
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

                  <a class="dropdown-item" href="settings.php"><i class="fas fa-fw fa-cog"></i> &nbsp; Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../logout.php"> <i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
               </div>
            </li>
         </ul>
      </nav>
      <div id="wrapper">
         <!-- Sidebar -->
         <ul class="sidebar navbar-nav">
            <li class="nav-item active">
               <a class="nav-link" href="landing.php">
                  <i class="fas fa-fw fa-home"></i>
                  <span>Home</span>
               </a>
            </li>
            <li class="nav-item">
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
            <div class="container-fluid pb-0">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">

                              <video width="100%" height="315" src=" <?php echo $_SESSION['videoLocation']; ?>" controls frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></video>


                           </div>
                           <div class="single-video-title box mb-3">
                              <h2><?php echo $_SESSION['vidName']; ?></h2>
                              <!-- <p class="mb-0"><i class="fas fa-eye"></i> 2,729,347 views</p> -->
                           </div>
                           <div class="single-video-author box mb-3">
                              <div class="float-right">

                                 <?php
                                 $userid = $user->getUserID($_SESSION['email'], $con);
                                 $result3 = mysqli_query($con, "SELECT * FROM subscribedto WHERE userID='$userid' AND channelID='$channelID'");
                                 if ($result3->num_rows > 0) {
                                 ?>
                                    <form action="" method="post" style="display:inline;">
                                       <input type='number' value="<?php echo $channelID; ?>" name='channelIndex' style='display:none; '>
                                       <button class="btn btn-danger" name="subscribe" type="submit">Subscribed
                                       </button>
                                    </form>
                                 <?php
                                 } else {

                                 ?>
                                    <form action="" method="post" style="display:inline;">
                                       <input type='number' value="<?php echo $channelID; ?>" name='channelIndex' style='display:none; '>
                                       <button class="btn btn-danger" name="subscribe" type="submit">Subscribe
                                       </button>
                                    </form>
                                 <?php
                                 }

                                 ?>
                                 <a href="" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <i class="fa fa-share-alt" aria-hidden="true"></i>

                                 </a>

                                 <div class="dropdown-menu dropdown-menu-right">

                                    <p class="dropdown-item">

                                       <?php

                                       $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                       echo $actual_link;

                                       ?>

                                    </p>

                                 </div>

                                 <?php

                                 $userid = $user->getUserID($_SESSION['email'], $con);
                                 $result3 = mysqli_query($con, "SELECT * FROM likedvideos WHERE userID='$userid' AND videoID='$index1'");
                                 if ($result3->num_rows > 0) {
                                 ?>
                                    <form action="" method="POST" style="display:inline;">
                                       <button class="btn btn-primary border-none" name='like' type="submit"><i class="fa fa-thumbs-up"></i>
                                          <strong><?php echo $_SESSION['like']; ?></strong>
                                       </button>

                                    </form>
                                 <?php
                                 } else {
                                 ?>
                                    <form action="" method="POST" style="display:inline;">
                                       <button class="btn btn btn-outline-danger" name='like' type="submit"><i class="fa fa-thumbs-up"></i>
                                          <strong><?php echo $_SESSION['like']; ?></strong>
                                       </button>

                                    </form>
                                 <?php
                                 }
                                 ?>

                              </div>
                              <img class="img-fluid" src="https://www.seekpng.com/png/detail/413-4139803_unknown-profile-profile-picture-unknown.png" alt="">
                              <p><a href="channels-profile.php?channelID=<?php echo $channelID;  ?>"><strong><?php echo $_SESSION['channelName'] ?></strong></a>
                                 <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span>
                                 <br><br>
                              </p>

                           </div>
                           <div class="single-video-info-content box mb-3">

                              <h6>About :</h6>
                              <p><?php echo $_SESSION['about']; ?></p>

                           </div>

                           <div class="single-video-info-content box mb-3">
                              <h6>Comments Section :</h6>
                              <form method='get' action=''>
                                 <input type='number' name='videoGetter' value='<?php echo $index1; ?>' style='display:none;'>
                                 <input type='text' name='comment' class='btn btn-outline secondary' required style=' text-align:unset; display:inline; width:70%'>
                                 <button class="btn btn-outline-secondary" type='submit' name='addComment'>Add comment</button>
                              </form>
                           </div>
                           <div class="single-video-info-content box mb-3">
                              <?php
                              $fetchVideos = mysqli_query($con, "SELECT * FROM commentids where videoID = $index1");
                              while ($row1 = mysqli_fetch_assoc($fetchVideos)) {
                                 $commentID = $row1['commentID'];
                                 $fetchVideos2 = mysqli_query($con, "SELECT * FROM comment where commentID =  $commentID ");
                                 $row = mysqli_fetch_assoc($fetchVideos2);
                                 $userID = $row['userID'];
                                 $content = $row['content'];
                                 $fetchVideos3 = mysqli_query($con, "SELECT * FROM user where userID =  $userID ");
                                 $row3 = mysqli_fetch_assoc($fetchVideos3);
                                 $userName = $row3['userName'];
                              ?>

                                 <div style='padding-bottom: 30px;'>
                                    <h6><?php echo $userName; ?></h6>

                                    <p name='comment' class='btn btn-outline secondary' style='text-align:unset; width:70%; padding-top:-20px'><?php echo $content; ?></p>
                                 </div>

                              <?php
                              }

                              ?>
                           </div>



                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">

                           <?php
                           $fetchVideos = mysqli_query($con, "SELECT * FROM video ORDER BY videoID
                             DESC");
                           displayVideos($fetchVideos);

                           ?>

                        </div>
                     </div>
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



<?php
} else {
   $index = $_POST['channelIndex'];
   $index1 = intval($_GET['videoIndex']);
   $userid = $user->getUserID($_SESSION['email'], $con);
   $result3 = mysqli_query($con, "SELECT * FROM subscribedto WHERE userID='$userid' AND channelID='$index'");
   if ($result3->num_rows > 0) {
      $channel->unsubscribe($userid, $channelID, $con);
      header("location: video-page.php?videoIndex=" . $index1 . "");
   } else {
      $channel->subscribe($userid, $channelID, $con);
      header("location: video-page.php?videoIndex=" . $index1 . "");
   }
}
?>