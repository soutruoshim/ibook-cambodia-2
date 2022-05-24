<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../configuration/DatabaseApi.php';
// instantiate order object
include_once '../model/Order.php';
  
$database = new DatabaseApi();
$db = $database->getConnection();
  
$order = new Order($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->user_id) &&
    !empty($data->book_id) &&
    !empty($data->price) &&
    !empty($data->amount) &&
    !empty($data->payment_status) &&
    !empty($data->paid_document)
){
  
    // set order property values
    $order->user_id = $data->user_id;
    $order->book_id = $data->book_id;
    $order->price = $data->price;
    $order->amount = $data->amount;
    $order->payment_status = $data->payment_status;
    $order->paid_document = $data->paid_document;
    $order->create_dt = date('Y-m-d H:i:s');
  
    // create the order
    if($order->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "order was created."));
    }
  
    // if unable to create the order, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create order."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create order. Data is incomplete."));
}
?>