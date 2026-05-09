<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================
// لو همستخدم date("Y-m-d H:i:s"); نستخدم date_default_timezone_set()
//date_default_timezone_set("Africa/Cairo	"); 

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    if($where == null){

        $stmt = $con->prepare("SELECT  * FROM $table ");
    }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
  
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
  
    if($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }else{
        if($count > 0){
return array("status" => "success" , "data" => $data);
        }else{
         return array("status" => "failure");
        }
    }
   
}

function getData($table, $where = null, $values = null , $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }else{
        return $count;
    }

    
}


function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload( $dir ,$imageRequest)
{
  global $msgError;
  if(isset($_FILES[$imageRequest])){ // معناها لو الملف موجود

    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf" , "jpeg" , "svg" , "PNG"); //  يتم تحويل اللاحقات الكابتل الي سمول
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
  if ($imagesize > 2 * MB) {
    $msgError = "size";
  }
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  $dir ."/". $imagename);
    return $imagename;
  } else {
    return "fail";
  }
  } else {
    return "empty";
  }
  
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

      // End 
}

function printFailure($message="none"){
    echo json_encode(array("status"=> "fail","message" =>$message));

}

function printSucces($message="Done"){
    echo json_encode(array("status"=> "success","message" =>$message));

}

function result($count){
    if($count > 0){

        printSucces();
    }else{

        printFailure();
    }
}


function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = 'https://fcm.googleapis.com/v1/projects/ecommerce-b1d43/messages:send'; // url الخاص بال firebase المسؤل عن الاشعارات

    $fields = [
      "message" => [
          "topic" => $topic, // Target topic for notifications
          "notification" => [
              "title" => $title,
              "body" => $message,
          ],
          "data" => [
              "extra" => "value",
              "pageid" => $pageid,
              "pagename" => $pagename
          ]
      ]
  ];
  


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: Bearer ' . "ya29.c.c0ASRK0GaMt7CvDCh-6nMKLDA_of5LVazg7C0Gp2VIgXXManL0Ceq-5QP2De9CdF2xBOMxIlGUNLYaECS8558jxZT-27uW-gjAE9w9Duduz_j7AcTeFAZ6g6T7_F7UFK_mr14Q3khALtBD_LEXPY_Ed3yXWZ12fpbr_4l_D8jngVDKYowairfPEu3KPTU_wQtRSpZBcOW7iBAGWffkfhYEeryj3wzCE-NjEZ6ZsT7_8J48617T1zxlNX9cLr4Om39wR3P8VFiOIrCIyDW98m9L6HGEtEUg4eSuYDUuEE8PU336GA1CCKkuwgy3MK3GU9NOWCHX9TzaEBC7X0xjX7DNT477OpG2rYNsQnHCg-1HtNftcHTZhp0g1BYL384PgvVzjx4O7kBdMF8o5XvfhbOeWrSMw5pv4Rk5bFk2o-748mu65g9ytkwMBhFSt0_lhVXqreOxjdpkoqoaVkVi38XutW14WUaz3mR6pkQdjwUJ0OiW8XqO6YVxciwhw4fiWbvUnXq4vISI7-_BtQ2SMwwQ7QxXy-MBZrJq-4OB1nRFZmutqu5vOtXXsJ72hWjU2X0qO6X7o_RYvevult2SS3QVzc5_h8tnO7yVzFSMvmmodRcJZph4tcpBIxMIW1X4amjmyycz0i1nb2wgJVclyQzRj-ehUXJlmROYrr4Q7Z5oyw6mr7gez9n8lpw5Qq8B002j1XrvUlO_otgWqSp5hzvS0u2WnfQjnfOI6t2wFkSoFvn84lu_u00zb546FerVgjkvU068yWUOycxY3_QQQS_V2Qg2WU7Rupfw2Ybfxe7aOkOVMeqQJmsVtRgYxgQy03xO6kt_gBOUvowYoa23ymQbFggeBojogaRRx8fV7WeZR6dhZUujYSl3ZyBckxVeWlyfgd2zxf7l3bdhhYYoOzmj5r56Omwuty82iZy7WxyUQQoRbI7r7pcJYjWcro1fRsvav6UudWVrby1wBeBBqme8jmw9V5hzgJ8_FbZ03a",  //ربط الباك ايند بالفايربيز
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}   


function insertNotify($title , $body , $userid , $topic , $pageid , $pagename){
    global $con;

    $stmt = $con->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_userid`) VALUES (? , ? , ? )");

    $stmt->execute(array($title , $body , $userid));

    sendGCM($title , $body , $topic , $pageid , $pagename);
    $count = $stmt ->rowCount();

    return $count;

}