<?php

include 'config.php';

//Check connection

if($mysql->connect_error){
echo "Connection failed: ". $mysql->connect_error;
} else {
echo "Connected successfully\n";
}

//Check that the table exists or not and create a table if not exists one.
$sql = "CREATE TABLE IF NOT EXISTS items (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
model VARCHAR(500) NOT NULL,
brand VARCHAR(500) NOT NULL,
image VARCHAR(500) NOT NULL,
info VARCHAR(500) NOT NULL,
price INT(20) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($mysql->query($sql) === TRUE) {
  echo "Table items created successfully\n";
} else {
  echo "Error creating table: " . $mysql->error;
}

?>
