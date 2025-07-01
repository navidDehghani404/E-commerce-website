<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'navidddehghanii@gmail.com'; // ایمیل شما
    $mail->Password   = 'hrcqxyxfibmrnsbx'; // پسورد اپلیکیشن
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // رفع خطای 530
    $mail->Port       = 587;

    $mail->setFrom('navidddehghanii@gmail.com', 'navid dehghani');
    $mail->addAddress('navidfortnite1387@gmail.com', 'Receiver Name');

    $mail->isHTML(false);
    $mail->Subject = 'test';
    $mail->Body    = 'It`s a test message.';

    $mail->send();
    echo '✅ ایمیل با موفقیت ارسال شد!';
} catch (Exception $e) {
    echo "❌ خطا در ارسال ایمیل: {$mail->ErrorInfo}";
}
?>
