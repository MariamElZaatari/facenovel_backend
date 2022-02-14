<?php

class BlockController
{
    // likes_id	user_id	post_id
    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $blocked_user_id = $_POST["blocked_user_id"];

        $query = $mysqli->prepare("INSERT INTO `block` VALUES (NULL,?,?)");
        $query->bind_param("ss", $user_id, $blocked_user_id);
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
        $blocked_user_id = $_POST["blocked_user_id"];

        $query = $mysqli->prepare("DELETE FROM block WHERE user_id=? AND blocked_user_id=?");
        $query->bind_param("ss", $user_id, $blocked_user_id);
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
    public function getBlockedUsers()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT blocked_user_id FROM block WHERE user_id = '$user_id';");
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