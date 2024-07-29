<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require "../../PHPMailer-master/src/Exception.php";
    require "../../PHPMailer-master/src/PHPMailer.php";
    require "../../PHPMailer-master/src/SMTP.php";

    class Mail{
        public static function sendMail($email, $naslov, $body, $ime, $prezime){
            $mail = new PHPMailer(true);

            try{
                $mail -> SMTPDebug = SMTP::DEBUG_OFF;
                $mail -> SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
                $mail->CharSet = 'utf-8';

                $mail->isSMTP(); 
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true; 

                $mail -> Username = 'katarina.milicevic.57.19@ict.edu.rs';
                $mail -> Password = 'daNmpjaE';

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail -> Port = 465;

                $mail -> setFrom('example@gmail.com', 'Ime Prezime');
                $mail -> addAddress("{$email}", "{$ime} {$prezime}" );

                $mail -> isHTML(true);
                $mail -> Subject = $naslov;
                $mail -> Body = $body;

                $mail -> send();
                return ("Uspešno ste se registrovali. Proverite email.");
            }
            catch(Exception $e){
                echo "Poruka ne može biti poslana. Mailer error: {$mail -> ErrorInfo}";
            }
        }
    }
?>