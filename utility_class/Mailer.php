<?php
namespace utility_class;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mailer {
    public function sender($address,$code)
    {

        require '../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'navidddehghanii@gmail.com';
            $mail->Password   = 'ndagjatovzdsxebx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('navidddehghanii@gmail.com', 'WebStore');
            $mail->addAddress($address, 'Receiver Name');

            $mail->isHTML(false);
            $mail->Subject = 'Verification code';
            $mail->Body    = 'The verificaion code to sign up in Webstore is :'.PHP_EOL.$code;

            $mail->send();
        } catch (Exception $e) {
        }
    }
}