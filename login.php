<?php
// Incluir la libreria PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'config.php';

$email = $_GET["email"];
$pwd = $_GET["pwd"];

// Función para generar un código de verificación
function generarCodigoVerificacion($longitud = 6) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) < 1) {
    $status = "failed";
    echo json_encode(array("response" => $status));
} else {
    $row = mysqli_fetch_assoc($result); 
    $stored_pwd = $row['pwd'];
    
    // Verificar la contraseña almacenada usando password_verify
    if (password_verify($pwd, $stored_pwd)) {
        $status = "ok";
        
        // Generar un código de verificación
        $codigoVerificacion = generarCodigoVerificacion();
        
        // Actualizar el código de verificación en la base de datos
        $sql_update_code = "UPDATE users SET verification_code = '$codigoVerificacion' WHERE email = '$email'";
        mysqli_query($con, $sql_update_code);
        
        // Enviar correo electrónico con el código de verificación
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'glass24pro@gmail.com';  // Reemplaza con tu correo
            $mail->Password = 'hixlkzyvzhojdchr';  // Reemplaza con tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('glass24pro@gmail.com', 'Pantallas');
            $mail->addAddress($email); // Enviar al correo autenticado
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';

            // Cuerpo del correo en HTML
            $mail->Body = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        color: #333;
                        line-height: 1.6;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 20px auto;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        background-color: #f9f9f9;
                    }
                    .header {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px;
                        text-align: center;
                        border-radius: 8px 8px 0 0;
                    }
                    .content {
                        padding: 20px;
                        text-align: center;
                    }
                    .code {
                        font-size: 24px;
                        font-weight: bold;
                        color: #4CAF50;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #777;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Verificación de Cuenta</h1>
                    </div>
                    <div class="content">
                        <p>Hola,</p>
                        <p>Has iniciado sesión exitosamente con tu cuenta. Para completar el proceso, usa el siguiente código de verificación:</p>
                        <div class="code">' . $codigoVerificacion . '</div>
                        <p>Este código es válido por 10 minutos.</p>
                    </div>
                    <div class="footer">
                        <p>Si no solicitaste este código, por favor ignora este mensaje.</p>
                        <p>&copy; ' . date('Y') . ' Tu Empresa. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->send();
            echo json_encode(array("response" => $status, "email" => $email));
        } catch (Exception $e) {
            // En caso de error al enviar el correo
            echo json_encode(array("response" => $status, "email" => $email, "mail_error" => $mail->ErrorInfo));
        }
    } else {
        $status = "failed";
        echo json_encode(array("response" => $status));
    }
}
?>