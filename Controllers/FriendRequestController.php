<?php 
include("../DB/DBConnection.php");

class FriendRequestController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";
        $requester_id = $_POST["requester_id"];
        $receiver_id = $_POST["receiver_id"];
        $status="pending";
        $date_created = date("Y-m-d H:i:sa");
        $date_updated = date("Y-M-D H:i:sa");

        $query = $mysqli->prepare("INSERT INTO `friend_request` VALUES (NULL,?,?,?,?,?)");
        $query->bind_param("iisss", $requester_id, $receiver_id, $status, $date_created, $date_updated);
        $query->execute();
    }

    // No Update for Likes Table
    public function update()
    {
        include "../DB/DBConnection.php";

        $requester_id = $_POST["requester_id"];
        $receiver_id = $_POST["receiver_id"];
        $status=$_POST["status"];
        $date_created = date("Y-m-d H:i:sa");
        $date_updated = date("Y-M-D H:i:sa");

        $query = $mysqli->prepare("UPDATE `friend_request` SET `status`=? `date_updated`=? WHERE requester_id=? AND receiver_id=?;");
        $query->bind_param("sii", $status, $requester_id, $receiver_id);
        $query->execute();
    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $requester_id = $_POST["requester_id"];
        $receiver_id = $_POST["receiver_id"];

        $query = $mysqli->prepare("DELETE FROM friend_request WHERE requester_id=? AND receiver_id=?");
        $query->bind_param("ii", $requester_id , $receiver_id);
        $query->execute();
    }

    public function getFriendRequestsByUserID()
    {
        include "../DB/DBConnection.php";

        $receiver_id = $_POST["receiver_id"];
        $query = $mysqli->prepare("SELECT f.requester_id, u.first_name, u.last_name, u.profile_pic, 
        u.bio_text
        FROM friend_request as f
        JOIN user_info as u
        ON f.requester_id=u.user_id 
        WHERE receiver_id = ? AND f.status='pending' 
        ORDER BY f.date_created DESC;");
        $query->bind_param("i", $receiver_id);
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