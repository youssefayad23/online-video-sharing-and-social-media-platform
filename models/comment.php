<?php

    require_once 'user.php';

    class Comment
    {
        private $userID;
        private $content;
        private $likes;
        private $dislikes;
        private $commentID;
        

     
        public function __construct()
        {
            
        }

        public function addComment($commentContent, $userID, $con){

            $sql = "INSERT INTO comment (content, userID) VALUES ('$commentContent', '$userID')";
            $result = mysqli_query($con, $sql);
            return $result;
        }

    }
