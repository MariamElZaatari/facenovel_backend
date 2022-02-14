<?php
// CRUD Operation
class WorkController
{
    // work_id	user_id	company_name	date_from	date_to	date_created	date_updated

    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $company_name = $_POST["company_name"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $date_created = $_POST["date_created"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("INSERT INTO `work` VALUES (NULL,?,?,?,?,?,?)");
        $query->bind_param("isssss", $user_id, $company_name, $date_from, $date_to, $date_created, $date_updated);
        $query->execute();
    }

    public function update()
    {
        include "../DB/DBConnection.php";

        $work_id = intval($_POST["work_id"]);
        $company_name = $_POST["company_name"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $date_created = $_POST["date_created"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("UPDATE `work` SET `company_name`=?,`date_from`=?,`date_to`=?,`date_created`=?,`date_updated`=? WHERE `work_id`=?");
        $query->bind_param("sssssi", $company_name, $date_from, $date_to, $date_created, $date_updated, $work_id);
        $query->execute();
    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $work_id = $_POST["work_id"];
        $query = $mysqli->prepare("DELETE FROM work WHERE work_id=?");
        $query->bind_param("i", $work_id);
        $query->execute();
    }

    // No need for read all work
    // public function read()
    // {
    // }

    public function getWorkByUserID()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT * FROM work WHERE user_id=? ORDER BY date_from DESC, date_to DESC,company_name");
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
