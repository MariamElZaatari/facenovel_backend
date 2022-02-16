<?php

class Validator
{

    public function phone($phone)
    {
        if (preg_match("/^[0-9]{8}$/", $phone)) {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Invalid Phone Number"));
        return false;
    }

    public function email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Invalid Email"));
        return false;
    }

    public function gender($gender)
    {
        if ($gender == "m" || $gender == "M" || $gender == "f" || $gender == "F") {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Invalid Gender Type"));
        return false;
    }

    public function name($name)
    {
        if (preg_match("/^([a-zA-Z' ]+)$/", $name)) {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Invalid input"));
        return false;
    }

    public function text($text)
    {
        if (strlen($text) >= 1) {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Post is too Short"));
        return false;
    }

    public function date($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) == $date) {
            return true;
        }

        echo json_encode(array("status" => 400, "message" => "Invalid Date"));
        return false;
    }

    public function id($id)
    {
        if (is_numeric($id)) {
            return true;
        } else {
            echo json_encode(array("status" => 400, "message" => "Invalid input ID"));
            return false;
        }
    }
}
