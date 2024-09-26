<?php
include 'config.php';

$email = $_GET["email"];
$verification_code = $_GET["verificationCode"];

// Verificar conexión a la base de datos
if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

// Consulta para verificar el código de verificación
$sql = "SELECT * FROM users WHERE email = '$email' AND verification_code = '$verification_code'";
$result = $mysql->query($sql);

if ($result->num_rows > 0) {
    // Código de verificación es correcto
    $status = "ok";
    
    // Actualizar el estado del usuario (establecer 'ok' en la columna verification_code)
    $sql_update = "UPDATE users SET verification_code = 'ok' WHERE email = '$email'";
    if ($mysql->query($sql_update) === TRUE) {
        echo json_encode(array("response" => $status, "message" => "Codigo de verificacion correcto y estado actualizado."));
    } else {
        echo json_encode(array("response" => "failed", "message" => "Error al actualizar el estado del usuario."));
    }
} else {
    // Código de verificación es incorrecto
    $status = "failed";
    echo json_encode(array("response" => $status, "message" => "Codigo de verificacion invalido."));
}
?>