<?php
//Including PhPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../../composer/vendor/autoload.php';

/* Creating a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail = new PHPMailer(TRUE);

try{
    $mail->setFrom('chrisblack123br456@gmail.com', 'Christopher Yepmo');
    $mail->addAddress('yepmochristopher@yahoo.fr', 'Chris');

    $mail->Subject = 'Force';
    $mail->Body = 'There is a great disturbance in the force';

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'chrisblack123br456@gmail.com';
    $mail->Password = 'Blancheneige123';
    $mail->Port = 587;

    #$mail->SMTPDebug = 4;

    $mail->send();
}
catch(Exception $e){
    echo $e->errorMessage();
}
catch(\Exception $e){
    /* PHP exception (note the backslash to select the global namespace Exception class). */
    echo $e->getMessage();
}
?>