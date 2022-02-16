<?php
require_once "../Validators/Validator.php";

// CRUD Operation
class PostController
{
    //post_id    user_id    text    date_created

    public function create()
    {
        include "../DB/DBConnection.php";
         // check if the values are set.
         if (!isset($_POST["user_id"]) || !isset($_POST["text"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::text($_POST["text"])) {
            $user_id = $_POST["user_id"];
            $text = $_POST["text"];
        } else {
            return false;
        }

        $date_created = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("INSERT INTO `post` VALUES (NULL,?,?,?)");
        $query->bind_param("iss", $user_id, $text, $date_created);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Post Added Successfully"));

    }

    //No Update for Post
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

         // check if the values are set.
         if (!isset($_POST["post_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["post_id"])) {
            $post_id = $_POST["post_id"];
        } else {
            return false;
        }

        $query = $mysqli->prepare("DELETE FROM post WHERE post_id=?");
        $query->bind_param("i", $post_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Post Deleted Successfully"));

    }

    public function read()
    {
        include "../DB/DBConnection.php";

        $query = $mysqli->prepare("SELECT p.post_id, u.first_name, u.last_name, u.profile_pic, p.text, p.date_created, Count(l.likes_id) as numOfLikes
        FROM post as p
        LEFT JOIN likes as l
        ON p.post_id=l.post_id
        JOIN user_info as u
        ON p.user_id=u.user_id
        GROUP BY p.post_id
        ORDER BY date_created DESC");
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }

        echo json_encode(array("status" => 200, "message" => "Post Data retrieved Successfully", "data"=> $array_response ));
    }
    
    public function getPostsByUserID()
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

        $query = $mysqli->prepare("SELECT p.post_id, u.first_name, u.last_name, u.profile_pic, p.text, p.date_created, Count(l.likes_id) as numOfLikes
        FROM post as p
        LEFT JOIN likes as l
        ON p.post_id=l.post_id
        JOIN user_info as u
        ON p.user_id=u.user_id
        WHERE u.user_id=?
        GROUP BY p.post_id
        ORDER BY date_created DESC");
        $query->bind_param("i", $user_id);
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }

        echo json_encode(array("status" => 200, "message" => "Post Data retrieved Successfully", "data"=> $array_response ));
    }
}
