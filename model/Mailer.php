<?php
define('MAIL_FROM','gest.on.inc@gmail.com');
define('CLAVE','Nohay2sin3');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './model/PHPMailer/Exception.php';
require './model/PHPMailer/PHPMailer.php';
require './model/PHPMailer/SMTP.php';



class Mailer {
    public static function sendMail($destino,$asunto="Notificacion",$cuerpo="Tienes un mensaje nuevo en tu Gestor de Incidencias"){
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = MAIL_FROM;                     // SMTP username
            $mail->Password   = CLAVE;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom(MAIL_FROM, 'Gest-On Incidencias');
            for ($i=0; $i < count($destino); $i++) { 
                $mail->addAddress($destino[$i]['correo'], $destino[$i]['nombre']);
            }
            
            

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpo;
            

            $mail->send();
            
        } catch (Exception $e) {
            echo "ERROR al enviar el mensaje: {$mail->ErrorInfo}";
        }
    }
}



?>