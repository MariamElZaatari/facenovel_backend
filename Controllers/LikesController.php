<?php

class LikesController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $post_id = $_POST["post_id"];

        $query = $mysqli->prepare("INSERT INTO `likes` VALUES (NULL,?,?)");
        $query->bind_param("ii", $user_id, $post_id);
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
        $post_id = $_POST["post_id"];

        $query = $mysqli->prepare("DELETE FROM likes WHERE user_id=? AND post_id=?");
        $query->bind_param("ii", $user_id, $post_id);
        $query->execute();
    }

    //No need for read function
    // public function read(){
    // }

    public function getLikesByUserID()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT Count(*) 
        FROM likes as l
        JOIN post as p
        ON l.post_id=p.post_id
        WHERE p.user_id=?
        GROUP BY p.user_id");
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