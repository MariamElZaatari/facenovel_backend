<?php

//Require_once includes the php file once by checking if it's already included
require_once "../Controllers/AuthController.php";
require_once "../Controllers/BlockController.php";
require_once "../Controllers/EducationController.php";
require_once "../Controllers/FriendController.php";
require_once "../Controllers/FriendRequestController.php";
require_once "../Controllers/LikesController.php";
require_once "../Controllers/PostController.php";
require_once "../Controllers/UserController.php";
require_once "../Controllers/WorkController.php";

//Example: facebook-back-end/router/router.php/post/create
$requested_url = $_SERVER["PHP_SELF"];

// post
$controller = explode("/", $requested_url)[4];
// create
$method = explode("/", $requested_url)[5];
// post/create
$server_path = $controller . "/" . $method;


switch ($server_path) {
    //Auth Controller
    case 'Auth/signup':
        AuthController::signup();
        break;
    case 'Auth/login':
        AuthController::login();
        break;
    //User Controller 
    case 'User/create':
        UserController::create();
        break;
    case 'User/read':
        UserController::read();
        break;
    case 'User/update':
        UserController::update();
        break;
    case 'User/delete':
        UserController::delete();
        break;

    //Work Controller 
    case 'Work/create':
        WorkController::create();
        break;
    case 'Work/update':
        WorkController::update();
        break;
    case 'Work/delete':
        WorkController::delete();
        break;
    case 'Work/getWorkByUserID':
        WorkController::getWorkByUserID();
        break;

    //Education Controller 
    case 'Education/create':
        EducationController::create();
        break;
    case 'Education/update':
        EducationController::update();
        break;
    case 'Education/delete':
        EducationController::delete();
        break;
    case 'Education/getEducationByUserID':
        EducationController::getEducationByUserID();
        break;
    
    //Likes Controller 
    case 'Likes/create':
        LikesController::create();
        break;
    case 'Likes/delete':
        LikesController::delete();
        break;
    case 'Likes/getLikesByUserID':
        LikesController::getLikesByUserID();
        break;
        
        //Post Controller 
        case 'Post/create':
            PostController::create();
            break;
        case 'Post/read':
            PostController::read();
            break;
        case 'Post/delete':
            PostController::delete();
            break;
        case 'Post/getPostsByUserID':
            PostController::getPostsByUserID();
            break;
    
    //Default
    default:
        echo json_encode(array("status"=>404, "message"=>"Server Cannot Find The Requested Resource"));
        break;
}
?>