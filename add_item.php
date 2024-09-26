<?php

include 'config.php';

//Check connection

if($mysql->connect_error){
echo "Error de conexión: ". $mysql->connect_error;
} else {
echo "Conexión extablecida\n";
}


$item = "";
$brand = "";
$image = "";
$info = "";
$price = "";
$stock = "";

//This function (empty()) will check that if the data inserted are empty or not
if(empty($_POST["item"]) || empty($_POST["price"])){

echo "Es necesario que su formulario contenga al menos un articulo y un precio.\n";

} else {
    

$item = $_POST["item"];

$brand = $_POST["brand"];

$image = $_POST["image"];

$info = $_POST["info"];

$price = $_POST["price"];  

$stock = $_POST["stock"];  


//Insert data into the table, items is the table name
$sql = "INSERT INTO items (item, brand, image, info, price, stock )
VALUES ('$item', '$brand', '$image', '$info', '$price', '$stock')";

if ($mysql->query($sql) === TRUE) {
  echo "Nuevo item agregado con éxito";
} else {
  echo "Error: " . $sql . "<br>" . $mysql->error;
}

}


?>
