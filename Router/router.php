<?php
// require_once("../Controllers/UserController.php");
// //Get path from the request with no domain name
// $request=$_SERVER["PHP_SELF"];

// //localhost/facebook-back-end/Router/Router.php/user/create
// // $controller_name=explode("/",$request)[5];
// // $controller_action=explode("/",$request)[6];
// $a=UserController::read();

// switch ($route){
    //Get the right directory of the ControllerName.php and import it into the router php file.
    // case "UserController":
    //     require __DIR__ . "/Controllers/UserController.php";
    //     break;
    // case "api2":
    //     require __DIR__ . "/Controllers/api2.php";
    //     break;
    // case "api3":
    //     require __DIR__ . "/Controllers/api3.php";
    //     break;
    // case "api4":
    //     require __DIR__ . "/Controllers/api4.php";
    //     break;
    // //If user case was none of the api, then a json object with a 404 status and page not found is sent;
    // default: 
    //     echo json_encode(array("status"=>404,"message"=>"Page Not Found"));
    //     break;
// }
?>