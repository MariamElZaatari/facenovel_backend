<?php
// CRUD Opertation
class PostController
{
    //post_id	user_id	text	date_created

    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $text = $_POST["text"];
        $date_created = $_POST["date_created"];

        $query = $mysqli->prepare("INSERT INTO `post` VALUES (NULL,?,?,?)");
        $query->bind_param("iss", $user_id, $text, $date_created);
        $query->execute();
    }

    //No Update for Post
    // public function update()
    // {
    // }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $post_id = $_POST["post_id"];
        $query = $mysqli->prepare("DELETE FROM post WHERE post_id=?");
        $query->bind_param("i", $post_id);
        $query->execute();
    }

    public function read(){
        include "../DB/DBConnection.php";

        $query = $mysqli->prepare("SELECT * FROM post ORDER BY date_created DESC");
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }
        $json_response = json_encode($array_response);
        echo $json_response;
    }
    public function getPostsByUserID()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT * FROM post WHERE user_id=? ORDER BY date_created DESC");
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