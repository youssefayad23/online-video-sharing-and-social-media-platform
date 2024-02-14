<?php
include_once '../../controllers/config.php';
include_once '../../controllers/displayer.php';
include_once '../../models/user.php';
include_once '../../models/video.php';
include_once '../../models/playlist.php';

if (!isset($_SESSION['userName'])) {
   header("Location: ../index.php");
}
?>
<?php
error_reporting(0);
//$playlistIndex = $_GET['playlistIndex'];
$user = new User();
$playlist = new Playlist();

if ($_GET['q'] == 'Search for...') {
   header('Location: landing.php');
}
if ($_GET['q'] !== '') {
   $con = mysqli_connect('localhost', 'root', '', 'streaming_platform');
   $q = $_GET['q'];
?>
   <?php
   if (!isset($_GET['videoGetter'])) {


   ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <!-- <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap"> -->
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
         <script type="text/javascript">
            function active() {
               var searchBar = document.getElementById('searchBar');
               if (searchBar.value == 'Search for...') {
                  searchBar.value = ''
                  searchBar.placeholder = 'search for...'
               }
            }

            function inactive() {
               var searchBar = document.getElementById('searchBar');

               if (searchBar.value == '') {
                  searchBar.value = 'Search for...'
                  searchBar.placeholder = ''
               }
            }
         </script>
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
                  <form action="landing.php" method="GET" id="searchForm">
                     <input type="text" name="q" id="searchBar" class="form-control" value="Search for..." placeholder="Search for..." onMouseDown="active();" onBlur="inactive();" required>
                     <div class="input-group-append">
                        <input id="searchBtn" class="btn btn-light" type="submit" value="Search"></input>
                     </div>
                  </form>


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
               <li class="nav-item ">
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

               <li class="nav-item active">
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
                  <div class="top-mobile-search">
                     <div class="row">
                        <div class="col-md-12">
                           <form class="mobile-search">
                              <div class="input-group">
                                 <input type="text" placeholder="Search for..." class="form-control">
                                 <div class="input-group-append">
                                    <button type="button" class="btn btn-dark"><i class="fas fa-search"></i></button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>

                  <div class="video-block section-padding">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="main-title">
                              <div class="btn-group float-right right-action">

                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                                 </div>
                              </div>
                              <h6>Videos</h6>
                           </div>
                        </div>

                        <?php
                        $playlistIndex = $_SESSION['playlistID']; {
                           if (!isset($q)) {
                              $query = mysqli_query($con, "SELECT * FROM video ORDER BY videoID
                            DESC");

                              displayPlaylistRemoveVideos($query, $playlistIndex, $con);
                           } else {
                              $query = mysqli_query($con, "SELECT * FROM video WHERE name LIKE '%$q%' OR description LIKE '%$q%'");

                        ?>
                        <?php

                              displayPlaylistRemoveVideos($query, $playlistIndex, $con);
                           }
                        }

                        ?>
                     </div>



                     <br>

                  </div>

               </div>

            </div>

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
      $playlistIndex = $_SESSION['playlistID'];
      $playlist->removeVideo($playlistIndex, $_GET['videoIndex'], $con);
      header("location: remove-vid.php?playlistIndex='.$playlistIndex.'");
   }
}
?>