<?php 
include("../DB/DBConnection.php");




class LikesController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";
        $requester_id = $_POST["user_id"];
        $receiver_id = $_POST["receiver_id"];

        $query = $mysqli->prepare("INSERT INTO `friend_request` VALUES (NULL,?,?)");
        $query->bind_param("ii", $user_id, $receiver_id);
        $query->execute();
    }

    //No Update for Likes Table
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $requester_id = $_POST["user_id"];
        $receiver_id = $_POST["post_id"];

        $query = $mysqli->prepare("DELETE FROM friend_request WHERE requester_id=? AND receiver_id=?");
        $query->bind_param("ii", $requester_id , $receiver_id);
        $query->execute();
    }

    public function read(){
        include "../DB/DBConnection.php";

        $query = $mysqli->prepare("");
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }
        $json_response = json_encode($array_response);
        echo $json_response;
    }
    public function getFriendReqs()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT requester_id FROM friend_request WHERE receiver_id = '$user_id';");
        $query->bind_param("i", $user_id);
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }
        $json_response = json_encode($array_response);
        echo $json_response;
    }
}

?>