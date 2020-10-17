<?php
require "./sources/inc/system.php";
require "./sources/class/PHPMailer/PHPMailer.php";
require "./sources/class/PHPMailer/SMTP.php";

class Email
{
    public $mail = null;

    public function __construct()
    {
        /*
         * email.protocol      = smtp
email.SMTPHost      = 'mail.recruit.adovasoft.com'
email.SMTPPort      = 26
email.SMTPUser      = 'no-reply@recruit.adovasoft.com'
email.SMTPPass      = 'Hafijul14_R'
email.SMTPCrypto    = '' #tls /ssl
email.SMTPTimeout   = 4
email.mailType      = html
email.encryption    = null
email.fromEmail     = 'no-reply@recruit.adovasoft.com'
email.fromName      = "Job Recruitment System"
email.userAgent     = 'CodeIgniter'
email.priority      = 3
email.validate      = TRUE
         */
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();                            // Set mailer to use SMTP
        $this->mail->Host = 'mail.recruit.adovasoft.com';              // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                     // Enable SMTP authentication
        $this->mail->Username = 'no-reply@recruit.adovasoft.com'; // your email id
        $this->mail->Password = 'Hafijul14_R'; // your password
        $this->mail->SMTPSecure = ''; //tls/ssl/''
        $this->mail->Port = 26;     //587 is used for Outgoing Mail (SMTP) Server.
        $this->mail->setFrom('no-reply@recruit.adovasoft.com', COMPANY);
        $this->mail->isHTML(true);  // Set email format to HTML
        $this->mail->Priority = 3;


    }

    public function send_email_to($to, $subject, $body)
    {
        /*
         $this->mail->addAddress('sendto@yahoo.com');   // Add a recipient
         */

        $bodyContent = '<h1>HeY!,</h1>';
        $bodyContent .= '<p>This is a email that Radhika send you From LocalHost using PHPMailer</p>';
        $this->mail->Subject = 'Email from Localhost by Radhika';
        $this->mail->Body = $bodyContent;
        if (!$this->mail->send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $this->mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
        }
    }

    public function print_money_recept($id = null)
    {

    }
}

