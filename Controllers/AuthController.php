<?php

include("../DB/DBConnection.php");


//init variables
$first_name ="";
$last_name = "";
$email = "";
$phone = "";
$gender = "";
$username = "";
$pass = "";
$dob = "";
//get dates
$date_created = date("Y-m-d");
$date_updated = date("Y-m-d");

//check if values are not null
if (isset($_POST["first_name"],$_POST["last_name"],$_POST["email"],
    $_POST["phone"],$_POST["gender"],$_POST["dob"],$_POST["gender"],$_POST["pass"],$_POST["username"];)){
    
        $first_name=$_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email=$_POST["email"];
        $username=$_POST["username"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];
        $pass = $_POST["password"];
      
     
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
       
       header("location:Login.php");
}
else {
    
     header("location:SignUp.php");
}


?>