<?php 
include("../DB/DBConnection.php");
$id = 64;
$get_user = $mysqli->prepare("SELECT requester_id,status FROM friend_request WHERE receiver_id = '$id';"); 
$get_user->execute();

//$query->store_result();
//print_r($query->num_rows);

$array = $get_user->get_result();

$array_response = [];
while($user = $array->fetch_assoc()){
    
    $array_response[] = $user;
}

$json_response = json_encode($array_response);
echo $json_response;
?>