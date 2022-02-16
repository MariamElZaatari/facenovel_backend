<?php
require_once "../Validators/Validator.php";

// CRUD Operation

class UserController
{
    public function create()
    {
        include "../DB/DBConnection.php";
         // check if the values are set.
         if (!isset($_POST["user_id"]) || !isset($_POST["first_name"]) || !isset($_POST["last_name"]) || !isset($_POST["email"]) || !isset($_POST["phone"]) || !isset($_POST["gender"]) || !isset($_POST["dob"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::name($_POST["first_name"]) && Validator::name($_POST["last_name"]) && Validator::date($_POST["dob"]) && Validator::email($_POST["email"]) && Validator::phone($_POST["phone"]) && Validator::gender($_POST["gender"])) {
            $user_id = intval($_POST["user_id"]);
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $dob = $_POST["dob"];
            $profile_pic = $_POST["profile_pic"];
            $bio_text = $_POST["bio_text"];
            $current_city = $_POST["current_city"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $gender = $_POST["gender"];

        } else {
            return false;
        }

        $date_created = date("Y-m-d h:i:sa");
        $date_updated = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("INSERT INTO `user_info` VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param("isssssssssss", $user_id, $first_name, $last_name, $email, $phone, $gender, $dob, $profile_pic, $bio_text, $current_city, $date_created, $date_updated);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "User Info Added Successfully"));

    }

    public function update()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["user_id"]) || !isset($_POST["first_name"]) || !isset($_POST["last_name"]) || !isset($_POST["email"]) || !isset($_POST["phone"]) || !isset($_POST["gender"]) || !isset($_POST["dob"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::name($_POST["first_name"]) && Validator::name($_POST["last_name"]) && Validator::date($_POST["dob"]) && Validator::email($_POST["email"]) && Validator::phone($_POST["phone"]) && Validator::gender($_POST["gender"])) {
            $user_id = intval($_POST["user_id"]);
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $dob = $_POST["dob"];
            $profile_pic = $_POST["profile_pic"];
            $bio_text = $_POST["bio_text"];
            $current_city = $_POST["current_city"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $gender = $_POST["gender"];

        } else {
            return false;
        }

        $date_updated = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("UPDATE `user_info` SET `first_name`=?,`last_name`=?,`email`=?,`phone`=?,`gender`=?,`dob`=?,`profile_pic`=?,`bio_text`=?,`current_city`=?,`date_updated`=? WHERE `user_id`=?");
        $query->bind_param("ssssssssssi", $first_name, $last_name, $email, $phone, $gender, $dob, $profile_pic, $bio_text, $current_city, $date_updated, $user_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "User Info Updated Successfully"));

    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["user_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"])) {
            $user_id = intval($_POST["user_id"]);

        } else {
            return false;
        }

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("DELETE FROM user_info WHERE user_id=?");
        $query->bind_param("i", $user_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "User Info Deleted Successfully"));

    }

    public function read()
    {
        include "../DB/DBConnection.php";

         // check if the values are set.
         if (!isset($_POST["user_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"])) {
            $user_id = intval($_POST["user_id"]);

        } else {
            return false;
        }

        $query = $mysqli->prepare("SELECT * FROM user_info WHERE user_id=?");
        $query->bind_param("i", $user_id);
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }

        echo json_encode(array("status" => 200, "message" => "User Info retrieved Successfully", "data" => $array_response[0]));
    }
}