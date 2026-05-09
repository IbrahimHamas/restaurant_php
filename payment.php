<?php
//الشرح: يسمح لتطبيق Flutter بالاتصال بالسيرفر

// السماح بالطلبات من التطبيق (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// المفتاح السري لـ Stripe (احفظه بشكل آمن)
$stripeSecretKey = "sk_test_51SVgpXRgi4JvM2u234mV6oUnSJrkXiJJekXthLUnZ1iQWGNmvycge8tKx5y2oqKlQ1ntyM2U72AjwhZsdsxz3qQY00qm4uCthA";


// قراءة البيانات المرسلة من التطبيق
//نقرأ البيانات المرسلة من التطبيق (JSON)
$input = file_get_contents('php://input');
//نحولها إلى مصفوفة PHP

$data = json_decode($input, true);

// التحقق من وجود البيانات المطلوبة
if (!isset($data['amount']) || !isset($data['currency'])) {
    echo json_encode([
        'error' => 'Missing required fields: amount and currency'
    ]);
    exit;
}

// الحصول على المبلغ والعملة
$amount = $data['amount'];
$currency = $data['currency'];

// البيانات التي سنرسلها إلى Stripe
$postData = http_build_query([
    'amount' => $amount,
    'currency' => $currency,
    'payment_method_types[]' => 'card'
]);

// إعداد طلب HTTP إلى Stripe API
//نستخدم cURL لإرسال طلب إلى Stripe

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $stripeSecretKey,
    'Content-Type: application/x-www-form-urlencoded'
]);

// إرسال الطلب والحصول على الرد
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// التحقق من نجاح الطلب
if ($httpCode == 200) {
    // إرجاع الاستجابة من Stripe إلى التطبيق
    echo $response;
} else {
    // في حالة حدوث خطأ
    echo json_encode([
        'error' => 'Failed to create payment intent',
        'details' => json_decode($response, true)
    ]);
}
?>