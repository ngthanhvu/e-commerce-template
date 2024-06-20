<?php     
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailer
{
     private $mail;
     public function __construct()
     {
          $this->mail = new PHPMailer(true);
          $this->mail->isSMTP();
          $this->mail->Host = 'smtp.gmail.com';
          $this->mail->SMTPAuth = true;
          $this->mail->Username = 'ngthanhvu205@gmail.com';
          $this->mail->Password = 'ncyp agwy mzvc zrwk';
          $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $this->mail->Port = 587;
     }

     public function sendMail($to, $subject, $body, $from = '', $fromName = '') {
          try  {
               $this->mail->setFrom($from, $fromName);
               $this->mail->addAddress($to);
               $this->mail->isHTML(true);
               $this->mail->Subject = $subject;
               $this->mail->Body = $body;
               $this->mail->send();
               return true;
          } catch (Exception $e) {
               echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
          }
     }
}
