<?php

include("connection.php");

//$name = $_POST["name"];
$first_name = "majd";
$last_name = "harb";
$email = "majd@harb.com";
$phone = "03253";
$gender = "M";
$dob = date("Y-m-d");
$date_created = date("Y-m-d");
$date_updated = date("Y-m-d");
$username = "majdharb";
$pass = "dsfsdf";

$insert_user_query = $mysqli->prepare(" INSERT INTO user(username, password, date_created, date_updated) 
VALUES (?,?,?,?)"); 
$insert_user_query->bind_param("ssss", $username,$pass,$date_created, $date_updated);
$insert_user_query->execute();


$query_id = $mysqli->prepare("Select user_id FROM user where username = '".$username."';");
$query_id->execute();

//$query->store_result();
//print_r($query->num_rows);

$array = $query_id->get_result();
$array_response = [];
while($user = $array->fetch_assoc()){
    print_r($user['user_id']);
    $array_response[] = $user;
}
$json_response = json_encode($array_response);
echo $json_response;


$insert_user_info_query = $mysqli->prepare(" INSERT INTO user_info(first_name, last_name, email, phone,gender,dob, date_created, date_updated) 
VALUES (?,?,?,?,?,?,?,?)"); 
$insert_user_info_query->bind_param("ssssssss", $first_name,$last_name,$email,$phone,$gender,$dob,$date_created, $date_updated);



$insert_user_info_query->execute();



?>