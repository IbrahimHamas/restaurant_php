<?php

include "../../connect.php";
require_once 'mail.php';


$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$type = filterRequest("ordertype");
$adminAccessToken = filterRequest("adminAccessToken");

if($type == 0){

$data = array(
    "orders_status" => 2 
);

} else {

    $data = array(
    "orders_status" => 4 // معناها ان الطلب وصل للزبون مباشرة في حالة الاستلام
);
}


  $count =  updateData("orders" , $data , "orders_id = $orderid AND orders_status = 1",false);


   if($count > 0){

 insertNotify("Success", "The Order has been Prepared", $userid , "user$userid",$adminAccessToken ,"none", "none");

if($type == 0){

    sendGCM("warning", "There is  an order awaiting approval", "delivery", $adminAccessToken,"none", "refreshPendingPage");


}

  echo json_encode(array(
        "status" => "success"
    ));

   } else{

      echo json_encode(array(
        "status" => "failure"
    ));

   }





