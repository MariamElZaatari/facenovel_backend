<?php

class FriendController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $friend_id = $_POST["friend_id"];

        $query = $mysqli->prepare("INSERT INTO `friend` VALUES (NULL,?,?)");
        $query->bind_param("ii", $user_id, $friend_id);
        $query->execute();
    }

    //No Update for Likes Table
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $friend_id = $_POST["friend_id"];

        $query = $mysqli->prepare("DELETE FROM friend WHERE user_one_id=? AND user_one_id=?");
        $query->bind_param("ii", $user_id , $friend_id);
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
        $get_user = $mysqli->prepare("SELECT user_two_id FROM friend WHERE user_one_id = '$user_id';"); 

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