<?php

class BlockController
{
    // block_id	user_id	blocked_user_id	date_created
    public function create()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $blocked_user_id = $_POST["blocked_user_id"];
        $date_created = date("Y-m-d");

        $query = $mysqli->prepare("INSERT INTO `block` VALUES (NULL,?,?,?)");
        $query->bind_param("iis", $user_id, $blocked_user_id, $date_created);
        $query->execute();
    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $blocked_user_id = $_POST["blocked_user_id"];

        $query = $mysqli->prepare("DELETE FROM `block` WHERE user_id=? AND blocked_user_id=?");
        $query->bind_param("ii", $user_id, $blocked_user_id);
        $query->execute();
    }

    
    public function getBlocksByUserID()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT b.blocked_user_id, u.first_name, u.last_name, u.profile_pic, 
        u.bio_text
        FROM `block` as b
        JOIN user_info as u
        ON b.blocked_user_id=u.user_id 
        WHERE b.user_id = ?
        ORDER BY b.date_created");
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