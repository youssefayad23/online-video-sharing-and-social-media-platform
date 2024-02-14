<?php
error_reporting(0);
session_start();
include_once "channel.php";

$host = "localhost";
$user = "root";
$password = "";
$dbname = "streaming_platform";
$con = mysqli_connect($host, $user, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


class User
{

    private $email;
    private $password;
    private $birthday;
    private $userName;
    private $userID;
    private $subscribedTo;
    private $likedVideos;
    private $disLikedVideos;
    private $userPlaylist;
    private $likedComment;
    private $disLikedComment;
    private $channelID;
    private $channel;



    function __construct()
    {
    }

    function addUser($userName, $email, $birthday, $password, $con)
    {

        $this->userName = $userName;
        // $sql = "SELECT * FROM user WHERE email='$this->userName'";
        // mysqli_query($con, $sql);

        $this->email = $email;
        // $sql = "INSERT INTO user (email) VALUES ('$this->email')";
        // $result = mysqli_query($con, $sql);

        $this->birthday = $birthday;
        // $sql = "INSERT INTO user (email) VALUES ('$this->birthday')";
        // mysqli_query($con, $sql);    

        $this->password = $password;
        // $sql = "INSERT INTO user (email) VALUES ('$this->password')";
        // mysqli_query($con, $sql);

        $sql = "INSERT INTO user (userName, email, birthday, password)
			VALUES ('$this->userName', '$this->email', '$this->birthday', '$this->password')";
        $result = mysqli_query($con, $sql);

        return $result;
    }


    public function updateUser($sessionEmail, $userName, $password, $con)
    {
        $sql = "UPDATE  user SET userName= '$userName' ,password='$password' WHERE email='$sessionEmail' ";
        $result = mysqli_query($con, $sql);
        return $result;
    }


    public function getUserInfo($sessionEmail, $con)
    {
        $result = mysqli_query($con, "SELECT * FROM user WHERE email='$sessionEmail'  ");
        $userRow = mysqli_fetch_array($result);
        return $userRow;
    }



    public function getUserID($sessionEmail, $con)
    {
        $result = mysqli_query($con, "SELECT * FROM user WHERE email='$sessionEmail'  ");
        $row = mysqli_fetch_array($result);
        return $row['userID'];
    }





    public function getIsCreator($sessionEmail, $con)
    {
        $result = mysqli_query($con, "SELECT * FROM user WHERE email='$sessionEmail'  ");
        $row = mysqli_fetch_array($result);
        return $row['isCreator'];
    }

    /**
     * Set the value of userID
     *
     * @return  self
     */
    public function setUserID($userID, $con)
    {
        $this->userID = $userID;
        $sql = "INSERT INTO user (userID) VALUES ('$this->userID')";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    public function authenticateUser($email, $password, $con)
    {
        $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public function getChannelInfo($userID, $con)
    {
        $this->channel = new channel();
        $this->channel->getUserChannelInfo($userID, $con);
    }

    public function deleteUser($userID, $con)
    {
        $sql = "DELETE FROM user WHERE userID='$userID' ";
        $result = mysqli_query($con, $sql);
    }
}
