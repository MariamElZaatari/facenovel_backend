<?php

class FriendController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_one_id"];
        $friend_id = $_POST["user_two_id"];
        $date_created = date("Y-m-d");

        $query = $mysqli->prepare("INSERT INTO `friend` VALUES (NULL,?,?,?)");
        $query->bind_param("iis", $user_id, $friend_id, $date_created);
        $query->execute();
    }

    //No Update for Likes Table
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_one_id"];
        $friend_id = $_POST["user_two_id"];

        $query = $mysqli->prepare("DELETE FROM friend WHERE user_one_id=? AND user_two_id=?");
        $query->bind_param("ii", $user_id , $friend_id);
        $query->execute();
    }

    public function getFriendsByUserID(){
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];

        
        $query = $mysqli->prepare("SELECT f.user_two_id, u.first_name, u.last_name, u.profile_pic, 
        u.bio_text
        FROM friend as f
        JOIN user_info as u
        ON f.user_two_id=u.user_id 
        WHERE user_one_id = ?
        UNION
        SELECT f.user_one_id, u.first_name, u.last_name, u.profile_pic, 
        u.bio_text
        FROM friend as f
        JOIN user_info as u
        ON f.user_one_id=u.user_id 
        WHERE user_two_id = ?
        ORDER BY first_name, last_name;");
        $query->bind_param("ii", $user_id, $user_id);
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