<?php
// اطلاعات پرداخت
$merchant_id = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
$amount = $_GET['total'];
$callback_url = "http://localhost/E-commerce Website/aboutUser/zarinpal/callback.php?total=$amount"; // آدرس بازگشت
$description = 'خرید تستی از سایت';

$data = [
    "merchant_id" => $merchant_id,
    "amount" => $amount,
    "callback_url" => $callback_url,
    "description" => $description
];

$ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/request.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$result = curl_exec($ch);
$result = json_decode($result, true);

if (isset($result["data"]) && isset($result["data"]["code"]) && $result["data"]["code"] == 100) {
    $authority = $result["data"]["authority"];
    $payment_url = "https://sandbox.zarinpal.com/pg/StartPay/" . $authority;
    header("Location: $payment_url");
    exit;
} else {
    echo "خطا در اتصال به زرین‌پال: ";
    print_r($result["errors"]);
}