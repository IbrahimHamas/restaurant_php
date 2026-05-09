<?php

//$notAuth = "";

//include "connect.php";

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
        'Authorization: Bearer ' . "ya29.c.c0ASRK0GYmQX0uNjjMWNR0xcGu2K95I__f8_NDrWIdALcsOchq6sy7sDQULG-p1_r9OgDwBBJPJz-UwaiCZ6UjZdCUCwgIuvBEFKfdrIto-hxo5WPo_l4QDSGBhHn9pfk1A4L-8Xf5z2dd5IamAoXfjUJWT6rkkcoDbTYRT3Pc7XRMaTkF2NIaDQhz7TdWkkb8injj3sSWolCaH2L2cO8XB7E_SprH68bBWVstOL0LhRjRrG06xDRX_oQ0sAUnkl4Eyvuh3ih3qv-u8veWZoeI7V9GiqErE0m2GlLDm-pP99iBxHrKcnKEsGu61fv9RlZDKsjWZgSEtzAToRuu-Dqm6xphgsjknYS3QtgPo7VDSwu2D81iqf5pwVIT384Cdf3B9Qz3t2y0zsm94RQUn8Wu8V3wWM1B_7bYSjkpBcS4gldalBpI1asdJBbavWIwjBOdQFOXf4Xwa1Fc84uxdeejOWcufheVhQ76XqMYOzoIkIxsYZ5wl6zt4s7-ioUM28Fz6-7Z7QJgn5_eI8_jWUahtW0f2qiSFZmu--MhWn7qmJzu4cwgM7k9fs7132pS1ncya52ln5Ui8VII1Fg4Mz7luYu1ef6iZqq5anOrwmob1XR7RSUx1Bj4Q42kBfeYqSi1MOgj72gFh58brha67SjMnla3twaJz5r9bkp9QORJq_Yll2IlM31Sz1VtxMvFixI3UZMh5kXUw6sYiapmhgpix_kw6ip9qFcsUUacSYUnl7fy1cpQJh9YtRsqmI3o9F4XF76R86OBnn9d0vZR5-Wl-FhWadlswaUmS9VdpVzZsiBxJjXlsOXsQk5Bs6wMm6jsfrWeJe94m9hihfdM6oz7io1doaOn-MhtU18x_9l9vjbaz85pbo7Ik40fjfs-V-QsXbre77vUu5Iq11FFS248Sr3bdUlFgdq4BOizq-Oy975zO-BaIjj7ds3_ZWygmi3Ym6c19F-rhBuSRQgI_5ugdad8s18JuMBdjm3Oca",  //ربط الباك ايند بالفايربيز
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

$result = sendGCM("Hi", "Login Successfully", "users37", "none", "refreshorderpending");
echo $result;
?>

