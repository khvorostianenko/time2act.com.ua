<?php

class Mail{
    static function send_mail($email, $message)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.yandex.ru';                      // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'phpmailer2017@yandex.ru';            // SMTP username
        $mail->Password = 'qerjar34';                         // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('phpmailer2017@yandex.ru', "no-reply");
        $mail->addAddress($email);               // Add a recipient
        $mail->Subject = 'Смена пароля time2act.com.ua';
        $mail->Body = $message;

        if (!$mail->send()) {
            $msg = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        } else {
            $msg = 'На Вашу почту отправлен проверочный код';
        }
        return $msg;
    }
}