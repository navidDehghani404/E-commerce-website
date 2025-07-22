<?php
$merchant_id = 'zarinpal-c5e7e2e0-a88b-11e8-8c63-000c29344814';
$amount = $_GET['total'];

if ($_GET['Status'] == 'OK') {
    $authority = $_GET['Authority'];

    $data = [
        "merchant_id" => $merchant_id,
        "amount" => $amount,
        "authority" => $authority
    ];

    $ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/verify.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $result = curl_exec($ch);
    $result = json_decode($result, true);

    if (isset($result["data"]) && $result["data"]["code"] == 100) {
        echo "✅ پرداخت موفق بود<br>";
        echo "💳 شماره تراکنش: " . $result["data"]["ref_id"];
    } else {
        echo "❌ پرداخت ناموفق بود<br>";
        echo "پیام خطا: " . $result["errors"]["message"];
    }

} else {
    echo "❌ کاربر پرداخت را لغو کرد";
}