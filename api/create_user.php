<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/ibook-cambodia-2/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../configuration/DatabaseApi.php';
include_once '../model/UserApi.php';
 
// get database connection
$database = new DatabaseApi();
$db = $database->getConnection();
 
// instantiate product object
$user = new UserApi($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

$email_exists = $user->emailExists();
if(!$email_exists){
     // create the user
    if(
        !empty($user->firstname) &&
        !empty($user->lastname) &&
        !empty($user->email) &&
        !empty($user->password) &&
        $user->create()
    ){
    
        // set response code
        http_response_code(200);
    
        // display message: user was created
        echo json_encode(array(
            "status" => "success",
            "message" => "User was created."
        ));
    }else{
        // message if unable to create user
        // set response code
        http_response_code(400);
    
        // display message: unable to create user
        echo json_encode(array( "status" => "fail","message" => "Unable to create user."));
    }
}else{
     // set response code
     http_response_code(200);
    
     // display message: user was created
     echo json_encode(array( "status" => "fail","message" => "User existed."));
}
?>