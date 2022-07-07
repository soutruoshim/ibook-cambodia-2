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
    !empty($data->book_id)
){
  
    // set order property values
    $order->user_id = $data->user_id;
    $order->book_id = $data->book_id;

    //var_dump($order);
   
    // create the order
        $order->checkOrder();
        
  
        // set response code - 201 created
        http_response_code(201);
        $order->user_id = $order->user_id;
        $order->book_id = $order->book_id;
        $order->price = $order->price;
        $order->amount = $order->amount;
        $order->payment_status = $order->payment_status;
        $order->paid_document = $order->paid_document;
        $order->create_dt = $order->create_dt;
        // tell the user
        echo json_encode(array(
            "status" => "success.",
            "order"=> array(
                "user_id" => $order->user_id,
                "book_id" => $order->book_id,
                "price" => $order->price,
                "amount" => $order->amount,
                "payment_status"=> $order->payment_status,
                "paid_document"=>$order->paid_document,
                "create_dt"=> $order->create_dt
            )
        ));
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create order. Data is incomplete."));
}
?>