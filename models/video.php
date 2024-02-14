<?php


    require_once 'comment.php';
    require_once 'channel.php';



    class Video
    {

        private $name;
        private $url;
        private $videoID;
        private $description;
        private $location;
        private $likes;
        private $dislikes;
        private $uploadDate;
        private $channelID;
        private $commentIDs;
       

        
        function __construct()
        {
            
        }

        function uploadVideo($name, $description, $location, $url, $channelID, $con) {
                
            $this->name = $name;
            $this->description = $description;
            $this->location = $location;
            $this->url = $url;

            $sql = "INSERT INTO video(name, description, location, url, channelID) 
            VALUES ('" . $name . "','" . $description . "','" .  $location . "','" . $url . "', $channelID)";
			$result = mysqli_query($con, $sql);

            return $result;
        }



        public function getVidInfo($ID, $con)       
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow;
        }


        public function getName($ID, $con)       
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow['name'];
        }

        public function getLocation($ID, $con)
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow['location'];
        }

        public function getDescription($ID,$con)
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow['description'];
        }

        
        
        public function getLikes($ID, $con)
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow['likes'];
        }

        public function getChannelID($ID, $con)
        {
            $vidResult = mysqli_query($con, "SELECT * FROM video WHERE videoID ='$ID' ");
            $vidRow = mysqli_fetch_array($vidResult);
            return $vidRow['channelID'];
        }

        public function like($userID, $videoID, $con)
        {
            $result1 = mysqli_query($con, "SELECT * FROM video WHERE videoID='$videoID'");
            $row1 = mysqli_fetch_array($result1);
            $n = $row1['likes'];
            $sql = "UPDATE video set likes = $n + 1  where videoID = '$videoID'";
           mysqli_query($con, $sql);
      
            $sql = "INSERT INTO likedvideos (userID,videoID) VALUES ('$userID','$videoID')";
             mysqli_query($con, $sql);
        }

        public function unlike($userID, $videoID, $con)
        {
            $result1 = mysqli_query($con, "SELECT * FROM video WHERE videoID='$videoID'");
            $row1 = mysqli_fetch_array($result1);
            $n = $row1['likes'];
            $sql = "UPDATE video set likes = $n - 1  where videoID = '$videoID'";
            mysqli_query($con, $sql);
      
            $sql = "DELETE FROM likedvideos WHERE userID='$userID' AND videoID='$videoID'";
             mysqli_query($con, $sql);
        }



      
    }

