<?php
require_once('../include/phpmailer/PHPMailerAutoload.php');
require_once("../include/phpmailer/class.phpmailer.php");
require_once("../include/phpmailer/class.smtp.php");

function notification_send($email, $subject, $message){
    $mail = new PHPMailer(); // create a new object
    $mail->SMTPAutoTLS = false;
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->Host = gethostbyname("smtp.endora.cz");
    $mail->SMTPOptions = array('ssl' => array('verify_peer_name' => false));
    $mail->Port = 31111;
    $mail->IsHTML(false);
    $mail->setLanguage('cz');
    $mail->SetFrom( $mail->Username, "Quaky" );
    $mail->CharSet="UTF-8";
    $mail->WordWrap = 50;
    $mail->DKIM_domain = "quaky.cz";
    $mail->DKIM_private = "keys/quaky.cz.quaky.cz.pem";
    $mail->DKIM_selector = "quaky.cz";

    // Content
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AddAddress("$email");

    if($mail->send()){
        return true;
    }else{
        return false;
    }
}
?>
