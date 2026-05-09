<?php

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");
$type = filterRequest("ordertype");
if($type == 0){

$data = array(
    "orders_status" => 2 
);

} else {

    $data = array(
    "orders_status" => 4 // معناها ان الطلب وصل للزبون مباشرة في حالة الاستلام
);
}


 updateData("orders" , $data , "orders_id = $orderid AND orders_status = 1 ");


   

 insertNotify("Success", "The Order has been approved", $userid , "users$userid", "none", "refreshorderpending");


if($type == 0){
sendGCM("warning", "there is  a order awaiting approval", "delivery", "none", "none");

}

