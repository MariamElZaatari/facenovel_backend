<?php
require_once "../Validators/Validator.php";

// CRUD Operation
class WorkController
{
    // work_id    user_id    company_name    date_from    date_to    date_created    date_updated

    public function create()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["user_id"]) || !isset($_POST["company_name"]) || !isset($_POST["date_from"]) || !isset($_POST["date_to"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["user_id"]) && Validator::name($_POST["company_name"]) && Validator::date($_POST["date_from"]) && Validator::date($_POST["date_to"])) {
            $user_id = $_POST["user_id"];
            $company_name = $_POST["company_name"];
            $date_from = $_POST["date_from"];
            $date_to = $_POST["date_to"];
        } else {
            return false;
        }

        $date_created = date("Y-m-d h:i:sa");
        $date_updated = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("INSERT INTO `work` VALUES (NULL,?,?,?,?,?,?)");
        $query->bind_param("isssss", $user_id, $company_name, $date_from, $date_to, $date_created, $date_updated);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Work Added Successfully"));

    }

    public function update()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["work_id"]) || !isset($_POST["company_name"]) || !isset($_POST["date_from"]) || !isset($_POST["date_to"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["work_id"]) && Validator::name($_POST["company_name"]) && Validator::date($_POST["date_from"]) && Validator::date($_POST["date_to"])) {
            $work_id = intval($_POST["work_id"]);
            $company_name = $_POST["company_name"];
            $date_from = $_POST["date_from"];
            $date_to = $_POST["date_to"];
        } else {
            return false;
        }

        $date_updated = date("Y-m-d h:i:sa");

        $query = $mysqli->prepare("UPDATE `work` SET `company_name`=?,`date_from`=?,`date_to`=?,`date_created`=?,`date_updated`=? WHERE `work_id`=?");
        $query->bind_param("sssssi", $company_name, $date_from, $date_to, $date_created, $date_updated, $work_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Work Updated Successfully"));

    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        // check if the values are set.
        if (!isset($_POST["work_id"])) {
            echo json_encode(array("status" => 400, "message" => "Some info is not set"));
            return false;
        }

        // validating the input.
        if (Validator::id($_POST["work_id"])) {
            $work_id = intval($_POST["work_id"]);
        } else {
            return false;
        }

        $query = $mysqli->prepare("DELETE FROM work WHERE work_id=?");
        $query->bind_param("i", $work_id);
        $query->execute();

        echo json_encode(array("status" => 200, "message" => "Work Deleted Successfully"));

    }

    // No need for read all work
    // public function read()
    // {
    // }

    public function getWorkByUserID()
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

        $query = $mysqli->prepare("SELECT * FROM work WHERE user_id=? ORDER BY date_from DESC, date_to DESC,company_name");
        $query->bind_param("i", $user_id);
        $query->execute();
        $array = $query->get_result();
        $array_response = [];

        while ($user_info = $array->fetch_assoc()) {
            $array_response[] = $user_info;
        }

        echo json_encode(array("status" => 200, "message" => "Work Data retrieved Successfully", "data" => $array_response));

    }
}
