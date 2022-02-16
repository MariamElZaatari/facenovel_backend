<?php

include "../DB/DBConnection.php";

class AuthController
{
    private function validateEmail($e)
    {
        $result = true;
        if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
            echo $e;
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function validateName($name)
    {
        $result = true;

        if (preg_match("/^([a-zA-Z' ]+)$/", $name)) {
            echo ucfirst($name);
            $result = true;
        } else {
            $result = false;
            echo ("errorrr");
        }
        return $result;
    }

    private function validatePhone($name)
    {
        $result = true;
        if (preg_match('/^[0-9]{8}$/', $name)) {
            $result = true;
        } else {
            $result = false;
            echo ("errorrr");
        }
        return $result;
    }

    private function validateGender($name)
    {
        $result = true;

        if ($name == "M" || $name == "F" || $name == "m" || $name == "f") {
            echo ($name);
            $result = true;
        } else {
            $result = false;
            echo ("errorrr");
        }
        return $result;
    }

    private function validatePassword($password)
    {
        $result = true;

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if ($uppercase && $lowercase && $number && $specialChars && strlen($password) > 8) {
            echo "finally";
            return true;
        } else {
            echo "bye";
            return false;
        }
    }

    private function matchPasswords($password, $password_repeated)
    {
        $result = true;
        if ($password == $password_repeated) {
            $result = true;
            echo ("match");
        } else {
            $result = false;
        }
        return $result;
    }
    public function signup()
    {
        include "../DB/DBConnection.php";

        //init variables
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];
        $pass = $_POST["password"];

        //get dates
        $date_created = date("Y-m-d");
        $date_updated = date("Y-m-d");

        //check if values are not null
        if (self::validateName($first_name) && self::validateName($last_name) && self::validateEmail($email)
            && self::validatePhone($phone) && isset($dob) && isset($username) && self::validateGender($gender)
            && self::validatePassword($pass) && self::matchPasswords($pass, $pass_repeat)) {
                
            //Hash password before storing
            $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

            //insert into user table
            $insert_user_query = $mysqli->prepare("INSERT INTO user(user_id,username, password, date_created, date_updated) VALUES (NULL,?,?,?,?)");
            $insert_user_query->bind_param("ssss", $username, $hashed_password, $date_created, $date_updated);
            $insert_user_query->execute();

            //Retrieves Last ID inserted using the connection mysqli
            $last_id = $mysqli->insert_id;

            //insert into user_info
            $insert_user_info_query = $mysqli->prepare("INSERT INTO user_info(user_id,first_name, last_name, email, phone,gender,dob, date_created, date_updated)
            VALUES (?,?,?,?,?,?,?,?,?)");
            $insert_user_info_query->bind_param("issssssss", $last_id, $first_name, $last_name, $email, $phone, $gender, $dob, $date_created, $date_updated);
            $insert_user_info_query->execute();
            
            //header("location:Login.php");
        } else {
            //header("location:Login.php");
        }
    }

    public function login()
    {
        include "../DB/DBConnection.php";

        //login code
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $get_hashed_password = $mysqli->prepare("SELECT password FROM user WHERE username = ?;");
        $get_hashed_password->bind_param("s", $username);
        $get_hashed_password->execute();
        $get_row = $get_hashed_password->get_result();
        $row = mysqli_fetch_array($get_row, MYSQLI_ASSOC);
        $hashed_password = $row['password'];

        if (password_verify($pass, $hashed_password)) {
            $get_user = $mysqli->prepare("SELECT user_id, username, date_created FROM user WHERE username = ? AND password=?;");
            $get_user->bind_param("ss", $username, $hashed_password);
            $get_user->execute();
            $get_user->store_result();
            $numOfRows= $get_user->num_rows;

            $get_user->execute();
            if ($numOfRows == 1) {
                $array = $get_user->get_result();
                $array_response = [];
                while ($user = $array->fetch_assoc()) {
                    $array_response[] = $user;
                }
                $json_response = json_encode(array("status"=>200, "data"=>$array_response[0]));
                echo $json_response;
            }
        } else{
            $json_response = json_encode(array("status"=>401, "message"=>"Unauthorized"));
            echo $json_response;
        }
    }
}