
<?php
// the delivery man agreed on the admin request 

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$deliveryid = filterRequest( "deliveryid");


$data = array(
    "orders_status" => 3,
    "orders_delivery" => $deliveryid // رقم عامل التوصيل
);

 updateData("orders" , $data , "orders_id = $orderid AND orders_status = 2 ");


   
/*
 insertNotify("Success", "your order is on the way", $userid , "users$userid", "none", "refreshorderpending");

//send done to store

sendGCM("warning" , "The order has been approved by delivery" , "services" , "none" , "none");

// a delivery man sends ok to admin
  
sendGCM("warning" , "The order has been approved by delivery" . $deliveryid , "delivery" , "none" , "none");
*/