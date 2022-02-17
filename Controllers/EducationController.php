<?php

require_once "../Validators/Validator.php";

// CRUD Operation
class EducationController
{
    // education_id    user_id    school_name    date_from    date_to    date_created    date_updated

    public function create()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["user_id"]) || !isset($_POST["school_name"]) || !isset($_POST["date_from"]) || !isset($_POST["date_to"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::name($_POST["school_name"]) && Validator::date($_POST["date_from"]) && Validator::date($_POST["date_to"])) {
            $user_id = $_POST["user_id"];
            $school_name = $_POST["school_name"];
            $date_from = $_POST["date_from"];
            $date_to = $_POST["date_to"];
        } else {
            return false;
        }

        $date_created = date("Y-m-d h:i:sa");
        $date_updated = date("Y-m-d h:i:sa");


        $query = $mysqli->prepare("INSERT INTO `education` VALUES (NULL,?,?,?,?,?,?)");
        $query->bind_param("isssss", $user_id, $school_name, $date_from, $date_to, $date_created, $date_updated);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Education Added Successfully"));



    }

    public function update()
    {
        include "../DB/DBConnection.php";

         // check if the values are set.
        if (!isset($_POST["education_id"]) || !isset($_POST["school_name"]) || !isset($_POST["date_from"]) || !isset($_POST["date_to"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["education_id"]) && Validator::name($_POST["school_name"]) && Validator::date($_POST["date_from"]) && Validator::date($_POST["date_to"])) {
            $education_id = intval($_POST["education_id"]);
            $school_name = $_POST["school_name"];
            $date_from = $_POST["date_from"];
            $date_to = $_POST["date_to"];
        } else {
            return false;
        }
        
        $date_updated = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("UPDATE `education` SET `school_name`=?,`date_from`=?,`date_to`=?, `date_updated`=? WHERE `education_id`=?");
        $query->bind_param("ssssi", $school_name, $date_from, $date_to, $date_updated, $education_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Education Updated Successfully"));

    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["education_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["education_id"])) {
            $education_id = intval($_POST["education_id"]);
        } else {
            return false;
        }

        $query = $mysqli->prepare("DELETE FROM education WHERE education_id=?");
        $query->bind_param("i", $education_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Education Deleted Successfully"));
    }

    // No need for read all education
    // public function read()
    // {
    // }

    public function getEducationByUserID()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["education_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["education_id"])) {
            $education_id = intval($_POST["education_id"]);
        } else {
            return false;
        }

        $query = $mysqli->prepare("SELECT * FROM education WHERE user_id=? ORDER BY date_from DESC, date_to DESC, school_name");
        $query->bind_param("i", $user_id);
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }

        echo json_encode(array("status"=> 200, "message"=>"Education Data Retrieved Successfully", "data"=> $array_response));
    }
}
