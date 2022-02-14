<?php
// CRUD Operation

class UserController
{
    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = intval($_POST["user_id"]);
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];
        $profile_pic = $_POST["profile_pic"];
        $bio_text = $_POST["bio_text"];
        $current_city = $_POST["current_city"];
        $date_created = $_POST["date_created"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("INSERT INTO `user_info` VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param("isssssssssss", $user_id, $first_name, $last_name, $email, $phone, $gender, $dob, $profile_pic, $bio_text, $current_city, $date_created, $date_updated);
        $query->execute();
    }

    public function update()
    {
        include "../DB/DBConnection.php";

        $user_id = intval($_POST["user_id"]);
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];
        $profile_pic = $_POST["profile_pic"];
        $bio_text = $_POST["bio_text"];
        $current_city = $_POST["current_city"];
        $date_created = $_POST["date_created"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("UPDATE `user_info` SET `first_name`=?,`last_name`=?,`email`=?,`phone`=?,`gender`=?,`dob`=?,`profile_pic`=?,`bio_text`=?,`current_city`=?,`date_created`=?,`date_updated`=? WHERE `user_id`=?");
        $query->bind_param("sssssssssssi", $first_name, $last_name, $email, $phone, $gender, $dob, $profile_pic, $bio_text, $current_city, $date_created, $date_updated, $user_id);
        $query->execute();

    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("DELETE FROM user_info WHERE user_id=?");
        $query->bind_param("i", $user_id);
        $query->execute();
    }

    public function read()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT * FROM user_info WHERE user_id=?");
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