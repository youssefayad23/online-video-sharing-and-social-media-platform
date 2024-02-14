<?php


    require_once 'video.php';

    class playlist
    {

        private $name;
        private $playlistID;
        private $videoIDs;

        public function __construct()
        {
            
        }
      
        public function addPlaylist($playlistTitle, $userID, $con) {
                
          

            $sql = "INSERT INTO playlist (title, userID) VALUES ('$playlistTitle', '$userID')";
            $result = mysqli_query($con, $sql);
            return $result;
        }


        public function addVideo($playlistID, $videoID ,$con){
            $sql = "INSERT INTO playlistvideoids (playlistID, videoID) VALUES ('$playlistID', '$videoID')";
            mysqli_query($con, $sql);
        }

        public function removeVideo($playlistID, $videoID ,$con){
            $sql = "DELETE FROM playlistvideoids WHERE playlistID='$playlistID' AND videoID='$videoID'";
            mysqli_query($con, $sql);
            
        }


    }
