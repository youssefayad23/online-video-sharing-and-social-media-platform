<?php

require_once 'user.php';
require_once 'video.php';

class Channel
{


    private $name;
    private $creationDate;
    private $about;
    private $subscribers;
    private $channelID;
    private $userID;
    private $videoIDs;


    public function __construct()
    {
    }
    public function __createChannel($sessionEmail, $channelName, $about, $userID, $con)
    {

        $sql = "INSERT INTO channel (channelName, about,user_id)
            VALUES ('$channelName', '$about','$userID')";
        mysqli_query($con, $sql);
        $sql = "UPDATE user SET isCreator='1' WHERE email='$sessionEmail' ";
        mysqli_query($con, $sql);
    }


    public function getChannelInfo($channelID, $con)
    {

        $result = mysqli_query($con, "SELECT * FROM channel WHERE channelID='$channelID'");
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function getUserChannelInfo($userID, $con)
    {

        $result = mysqli_query($con, "SELECT * FROM channel WHERE user_id='$userID'  ");
        $row = mysqli_fetch_array($result);
        return $row;
    }


    public function getChannelID($userID, $con)
    {
        $result = mysqli_query($con, "SELECT * FROM channel WHERE user_id='$userID'");
        $row = mysqli_fetch_array($result);
        return $row['channelID'];
    }

    public function subscribe($userID, $channelID, $con)
    {

        $sql = "INSERT INTO subscribedto (userID,channelID) VALUES ('$userID','$channelID')";
        mysqli_query($con, $sql);
    }

    public function unsubscribe($userID, $channelID, $con)
    {

        $sql = "DELETE FROM subscribedto WHERE userID='$userID' AND channelID='$channelID'";
        mysqli_query($con, $sql);
    }

    public function deleteChannel($channelID, $userID, $con)
    {
        $query = "DELETE FROM channel WHERE channelID='$channelID' AND user_id='$userID' ";
        mysqli_query($con, $query);
        $sql =  "DELETE FROM video WHERE channelID='$channelID' ";
        mysqli_query($con, $sql);
        $sql = "UPDATE  user SET isCreator='0' WHERE userID=$userID ";
        $result = mysqli_query($con, $sql);
    }
}
