<?php
include_once '../../controllers/config.php';
include_once '../../controllers/displayer.php';
include_once '../../models/user.php';
include_once '../../models/video.php';
include_once '../../models/channel.php';


if (!isset($_SESSION['userName'])) {
    header("Location: ../index.php");
}
?>
<?php

$user = new User();
$video = new Video();
$channel = new Channel();

$row = $channel->getUserChannelInfo($user->getUserID($_SESSION['email'], $con), $con);
$channelName = $row['channelName'];
$channelID = $row['channelID'];

if (!isset($_GET['videoGetter'])) {
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
                <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
                    <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img alt="Avatar" src="https://www.seekpng.com/png/detail/413-4139803_unknown-profile-profile-picture-unknown.png">
                        <?php echo $_SESSION['userName'] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="account.php"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
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
            <div class="single-channel-page" id="content-wrapper">
                <div class="single-channel-image">
                    <img class="img-fluid" alt="" src="img/channel-banner.png">
                    <div class="channel-profile">
                        <img class="channel-profile-img" alt="" src="https://www.seekpng.com/png/detail/413-4139803_unknown-profile-profile-picture-unknown.png">

                    </div>
                </div>
                <div class="single-channel-nav">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <p class="channel-brand"><?php echo $channelName ?> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></p>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="single-channel.php">Videos <span class="sr-only">(current)</span></a>
                                </li>

                                <li class="nav-item active">
                                    <a class="nav-link" href="my-about.php">About</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="deleteChannel.php">Delete Channel</a>
                                </li>
                            </ul>

                        </div>
                    </nav>
                </div>
                <div class="container-fluid">
                    <div class="video-block section-padding">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-title">

                                    <h6>About</h6>
                                </div>
                            </div>
                            <?php

                            $query = mysqli_query($con, "SELECT * FROM channel WHERE channelID='$channelID'  ");
                            displayChannelAbout($query);
                            ?>



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
    $index = $_GET['videoIndex'];
    header("location: video-page.php?videoIndex=" . $index . "");
}

?>