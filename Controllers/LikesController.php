<?php
require_once "../Validators/Validator.php";

class LikesController
{
    // likes_id	user_id	post_id

    public function create()
    {
        include "../DB/DBConnection.php";
         // check if the values are set.
         if (!isset($_POST["user_id"]) || !isset($_POST["post_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::id($_POST["post_id"])) {
            $user_id = $_POST["user_id"];
            $post_id = $_POST["post_id"];
        } else {
            return false;
        }


        // checking if the Like ALready Exists, then do not add like Again.
        $query = $mysqli->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
        $query->bind_param("ii", $user_id, $post_id);
        $query->execute();
        $query->store_result();

        if($query->num_rows() == 1){
            echo json_encode(array("status" => 200, "message" => "Like Already Exists"));
            return false;
        }


        $query = $mysqli->prepare("INSERT INTO `likes` VALUES (NULL,?,?)");
        $query->bind_param("ii", $user_id, $post_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Like Added Successfully"));

    }

    //No Update for Likes Table
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["user_id"]) || !isset($_POST["post_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::id($_POST["post_id"])) {
            $user_id = $_POST["user_id"];
            $post_id = $_POST["post_id"];
        } else {
            return false;
        }

        $query = $mysqli->prepare("DELETE FROM likes WHERE user_id=? AND post_id=?");
        $query->bind_param("ii", $user_id, $post_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Like Deleted Successfully"));

    }

    //No need for read function
    // public function read(){
    // }

    public function getLikesByUserID()
    {
        include "../DB/DBConnection.php";

         // check if the values are set.
         if (!isset($_POST["user_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"])) {
            $user_id = $_POST["user_id"];
        } else {
            return false;
        }


        $query = $mysqli->prepare("SELECT Count(*) as likes
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
        echo json_encode(array("status" => 200, "message" => "Likes Data retrieved Successfully", "data"=> $array_response[0]));
    }
}
?>