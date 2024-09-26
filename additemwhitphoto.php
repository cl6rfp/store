<?php
include 'config.php';

// Verificar la conexión
if ($mysql->connect_error) {
    echo "Error de conexión: " . $mysql->connect_error;
} else {
    echo "Conexión establecida\n";
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar que los campos requeridos estén presentes y no estén vacíos
    if (empty($_POST["item"]) || empty($_POST["price"])) {
        echo "Es necesario que su formulario contenga al menos un artículo y un precio.\n";
    } else {

        // Recoger los datos del formulario
        $item = $_POST["item"];
        $brand = $_POST["brand"];
        $info = $_POST["info"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $image = "000.jpg";

        // Verificar si se proporcionó una imagen y procesarla si es así
        if (isset($_POST['image']) && !empty($_POST['image'])) {
            // Decodificar la imagen de base64
            $imagen_decodificada = base64_decode($_POST['image']);

            // Crear un nombre de archivo único para la imagen
            $nombre_archivo = 'imagen_' . time() . '.jpg';

            // Ruta donde se guardará la imagen (ajustar según tu estructura de carpetas)
            $ruta_archivo = $_SERVER['DOCUMENT_ROOT'] . '/pantallas/photos/' . $nombre_archivo;

            // Guardar la imagen decodificada en el archivo especificado
            if (file_put_contents($ruta_archivo, $imagen_decodificada)) {
                $image = $nombre_archivo;
            } else {
                echo "Error al guardar la imagen en el servidor.";
            }
        }

        // Insertar datos en la tabla de items, incluyendo la URL de la imagen
        $sql = "INSERT INTO items (item, brand, info, image, price, stock)
                VALUES ('$item', '$brand', '$info', '$image', '$price', '$stock')";

        if ($mysql->query($sql) === TRUE) {
            echo "Nuevo item agregado con éxito";
        } else {
            echo "Error: " . $sql . "<br>" . $mysql->error;
        }
    }
}
?>