<?php

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$adminAccessToken =  filterRequest("adminAccessToken");

$data = array(
    "orders_status" => 1
);

 $count =  updateData("orders" , $data , "orders_id = $orderid AND orders_status = 0 ",false);


   if($count > 0){

 insertNotify("Success", "The Order has been approved", $userid ,"user$userid",$adminAccessToken,"", "");
  echo json_encode(array(
        "status" => "success"
    ));

   } else {

       echo json_encode(array(
        "status" => "failure"
    ));
   }




