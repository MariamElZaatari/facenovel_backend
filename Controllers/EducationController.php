<?php
// CRUD Operation
class EducationController
{
    // education_id    user_id    school_name    date_from    date_to    date_created    date_updated

    public function create()
    {
        include "../DB/DBConnection.php";
        $user_id = $_POST["user_id"];
        $school_name = $_POST["school_name"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $date_created = $_POST["date_created"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("INSERT INTO `education` VALUES (NULL,?,?,?,?,?,?)");
        $query->bind_param("isssss", $user_id, $school_name, $date_from, $date_to, $date_created, $date_updated);
        $query->execute();
    }

    public function update()
    {
        include "../DB/DBConnection.php";

        $education_id = intval($_POST["education_id"]);
        $school_name = $_POST["school_name"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $date_updated = $_POST["date_updated"];

        $query = $mysqli->prepare("UPDATE `education` SET `school_name`=?,`date_from`=?,`date_to`=?, `date_updated`=? WHERE `education_id`=?");
        $query->bind_param("ssssi", $school_name, $date_from, $date_to, $date_updated, $education_id);
        $query->execute();
    }

    public function delete()
    {
        include "../DB/DBConnection.php";

        $education_id = $_POST["education_id"];
        $query = $mysqli->prepare("DELETE FROM education WHERE education_id=?");
        $query->bind_param("i", $education_id);
        $query->execute();
    }

    // No need for read all education
    // public function read()
    // {
    // }

    public function getEducationByUserID()
    {
        include "../DB/DBConnection.php";

        $user_id = $_POST["user_id"];
        $query = $mysqli->prepare("SELECT * FROM education WHERE user_id=? ORDER BY date_from DESC, date_to DESC, school_name");
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
