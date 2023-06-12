<?php

namespace Supports\Facades;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Supports\Facades\Logger;

class Mail
{
    public $mail;
    public $data;

    public function __construct($data)
    {
        $this->mail = new PHPMailer(true);
        $this->data = $data;
    }

    public function send()
    {
        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = 'tmpdz7820@gmail.com';                     //SMTP username
            $this->mail->Password   = 'xqoseytyelaranqr';                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('tmpdz7820@gmail.com', 'GalaxyFW');
            $this->mail->addAddress($this->data['email'], $this->data['name']);     //Add a recipient

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->data['subject'];
            $this->mail->Body    = $this->data['body'];
            $this->mail->smtpConnect(array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            ));

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            Logger::error("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }
}
