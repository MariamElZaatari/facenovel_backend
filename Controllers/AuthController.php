<?php

include("../DB/DBConnection.php");
/*
//init variables
$first_name=$_POST["first_name"];
$last_name = $_POST["last_name"];
$email=$_POST["email"];
$username=$_POST["username"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$pass = $_POST["password"];
$pass_repeat = $_POST["password_repeat"];
$dob = $_POST["date"];

//get dates
$date_created = date("Y-m-d");
$date_updated = date("Y-m-d");


//check if values are not null
if (validateName($first_name) && validateName($last_name) && validateEmail($email) 
    && validatePhone($phone) && isset($dob) && isset($username) && validateGender($gender) 
    && validatePassword($pass) && matchPasswords($pass,$pass_repeat)){
    
        //insert into user table
        $insert_user_query = $mysqli->prepare("INSERT INTO user(username, password, date_created, date_updated) 
        VALUES (?,?,?,?)"); 
        $insert_user_query->bind_param("ssss", $username,$pass,$date_created, $date_updated);
        $insert_user_query->execute();

        //get user id
        $query_id = $mysqli->prepare("Select user_id FROM user where username = '".$username."';");
        $query_id->execute();

        $id;
        $array = $query_id->get_result();
        $array_response = [];
        while($user = $array->fetch_assoc()){
            $array_response[] = $user;
            $id = $user['user_id'];
        }
        print_r($id);
        //$json_response = json_encode($array_response);
        //echo $json_response;

        //insert into user_info
        $insert_user_info_query = $mysqli->prepare("INSERT INTO user_info(user_id,first_name, last_name, email, phone,gender,dob, date_created, date_updated) 
        VALUES (?,?,?,?,?,?,?,?,?)"); 
        $insert_user_info_query->bind_param("sssssssss",$id ,$first_name,$last_name,$email,$phone,$gender,$dob,$date_created, $date_updated);
        $insert_user_info_query->execute();
       
       //header("location:Login.php");
}else{
    //header("location:Login.php");
}

function validateEmail($e){
    $result = true;
    if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
        $result = true;
      } else {
        $result = false;
      }
    return $result;
}

function validateName($name){
    $result = true;

    if(preg_match("/^([a-zA-Z' ]+)$/",$name)){
        echo ucfirst($name);
        $result = true;
    }else{
        $result = false;
        echo ("errorrr");
    }
    return $result;
}

function validatePhone($name){
    $result = true;
    if(preg_match('/^[0-9]{8}$/',$name)){
        $result = true;
    }else{
        $result = false;
        echo ("errorrr");
    }
    return $result;
}

function validateGender($name){
    $result = true;

    if($name == "M" || $name == "F" || $name == "m" || $name == "f"){
        echo ($name);
        $result = true;
    }else{
        $result = false;
        echo ("errorrr");
    }
    return $result;
}

function validatePassword($password){
    $result = true;

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $result = true;
        echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        
    }else{
        echo 'Strong password.';
        $result = false;
    }
    return $result;

}

function matchPasswords($password, $password_repeated){
    $result = true;
    if($password === $password_repeated){
        $result = true;
        echo ("match");
    }else{
        $result = false;
    }
    return $result;
}
*/

//login code
$username=$_POST["username"];
$pass = $_POST["password"];

$get_user = $mysqli->prepare("SELECT user_id FROM user WHERE username = '$username' AND password = '$pass';"); 
$get_user->execute();

//$query->store_result();
//print_r($query->num_rows);

$array = $get_user->get_result();
$id;
$array_response = [];
while($user = $array->fetch_assoc()){
    $id = $user['user_id'];
    echo ($id);
    $array_response[] = $user;
}

$json_response = json_encode($array_response);
echo $json_response;

?>