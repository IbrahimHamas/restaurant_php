<?php

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$deliveryAccessToken = filterRequest("deliveryAccessToken");

$data = array(
    "orders_status" => 4
);

$count = updateData("orders" , $data , "orders_id = $orderid AND orders_status = 3 ", false);


   if($count > 0){

 insertNotify("Success", "your order has been delivered", $userid , "user$userid",$deliveryAccessToken ,"none", "refreshPendingPage");

sendGCM("warning" , "The order has been delivered to  the customer" , "admin" ,$deliveryAccessToken ,"none" , "refreshAcceptedPage");

// the delivery man agreed on the admin request 
  echo json_encode(array(
        "status" => "success"
    ));


   }else{

     echo json_encode(array(
        "status" => "failure"
    ));
   }



