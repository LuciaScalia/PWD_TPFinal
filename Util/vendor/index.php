<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'autoload.php';

//Crea una instancia de la clase para acceder a sus metodos
$mail = new PHPMailer(true);

try {
    //Configuracion del servidor SMTP de Gmail
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host      = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'nadiacarrasco83.nc@gmail.com';      //nombre gmail del emisor
    $mail->Password   = 'rnxc pupb kxfh urow';              //contraseña de aplicacion de gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      //para el cifrado TLS
    $mail->Port       = 587; //puerto para SMTP con TLS                             

    //Recipients
    $mail->setFrom('nadiacarrasco83.nc@gmail.com', 'Nadia'); //emisor
    $mail->addAddress('nadia.carrasco@est.fi.uncoma.edu.ar');     //mail receptor

    //Contenido
    $mail->isHTML(true); //envia mail con formato HTML
    $mail->Subject = 'Asunto'; //el asunto del mail
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>'; //el contenido del mail
    

    $mail->send();
    echo 'Enviado correctamente'; //mensaje para el desarrollador 
} catch (Exception $e) {
    echo "Error al enviar. Mailer Error: {$mail->ErrorInfo}"; //si no lo envía, le muestra al desarrollador el error
}