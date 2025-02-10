<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    $mail->SMTPSecure = "ssl";  
    $mail->Host='smtp.gmail.com';  
    $mail->Port='465';   
    $mail->Username   = 'nguyenhung16052001@gmail.com';  // SMTP account username
    $mail->Password   = 'mkgzzixzmahfzyef';   
    $mail->SMTPKeepAlive = true;  
    $mail->Mailer = "smtp"; 
    $mail->IsSMTP(); // telling the class to use SMTP  
    $mail->SMTPAuth   = true;                  // enable SMTP authentication  
    $mail->CharSet = 'utf-8';  
    $mail->SMTPDebug  = 0;   

    //Recipients
    $mail->setFrom('nguyenhung16052001@gmail.com', 'dinh hung');
    $mail->addAddress('16.05.01h@gmail.com', 'nguyen dinh hung');     // Add a recipient

    // // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>