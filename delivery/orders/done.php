<?php

include "../../connect.php";

$orderid =  filterRequest("ordersid");
$userid =  filterRequest("usersid");

$data = array(
    "orders_status" => 4
);

 updateData("orders" , $data , "orders_id = $orderid AND orders_status = 3 ");


   

 insertNotify("Success", "your order has been delivered", $userid , "users$userid", "none", "refreshorderpending");

sendGCM("warning" , "The order has been delivered to  the customer" , "services" , "none" , "none");

// the delivery man agreed on the admin request 

