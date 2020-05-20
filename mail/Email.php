<?php

namespace Mail;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

class Email
{

    /** @var PHPMailer */
    private $mail;
    /** @var stdClass */
    private $data;
    /** @var Exception */
    private $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();

        $this->mail->isSMTP();
//        $this->mail->isHTML();
        $this->mail->setLanguage('br');
        $this->mail->SMTPAuth = true;
//        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mail->Port = 587;
        $this->mail->CharSet = 'utf-8';
        $this->mail->Host = MAIL['host'];
        $this->mail->Port = MAIL['port'];
        $this->mail->Username = MAIL['user'];
        $this->mail->Password = MAIL['password'];
    }

    public function add(string $subject, string $body, string $recipiente_name, string $recipient_email): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipiente_name = $recipiente_name;
        $this->data->recipient_email = $recipient_email;
        return $this;
    }

    public function attach(string $filePatch, string $fileName)
    {
        $this->data->attach[$filePatch] = $fileName;
    }

    public function send(array $withCopies = [], string $from_name = MAIL['from_name'], string $from_email = MAIL['from_email'])
    {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->Body = $this->data->body;
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipiente_name);
            foreach ($withCopies as $cc) {
                if (!empty($cc)) {
                    $this->mail->addCC($cc);
                }
            }
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $patch => $name) {
                    $this->mail->addAttachment($patch, $name);
                }
            }

            return $this->mail->send();
        } catch (Exception $ex) {
            $this->error = $ex;
            return false;
        }
    }

    public function error()
    {
        return $this->error;
    }
}