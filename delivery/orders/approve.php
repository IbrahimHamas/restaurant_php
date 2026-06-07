
<?php
// the delivery man agreed on the admin request 

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$deliveryid = filterRequest( "deliveryid");
$deliveryAccessToken = filterRequest("deliveryAccessToken");



$data = array(
    "orders_status" => 3,
    "orders_delivery" => $deliveryid // رقم عامل التوصيل
);

$count = updateData("orders" , $data , "orders_id = $orderid AND orders_status = 2 ",false);


   if($count > 0){

 insertNotify("Success", "your order is on the way", $userid , "user$userid",$deliveryAccessToken ,"none", "none");

// a delivery man sends ok to admin
sendGCM("warning" , "The order has been approved by delivery" ." ".$deliveryid , "admin" ,$deliveryAccessToken ,"none" , "refreshAcceptedPage");

  echo json_encode(array(
        "status" => "success"
    ));


   } else {


       echo json_encode(array(
        "status" => "failure"
    ));
   }