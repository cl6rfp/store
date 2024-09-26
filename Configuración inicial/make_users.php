<?php

include 'config.php';

//Check connection

if($mysql->connect_error){
echo "Connection failed: ". $mysql->connect_error;
} else {
echo "Connected successfully\n";
}

//Check that the table exists or not and create a table if not exists one.
$sql = "CREATE TABLE IF NOT EXISTS users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
rol INT(30),
name VARCHAR(30),
email VARCHAR(50) NOT NULL,
phone VARCHAR(20),
pwd VARCHAR(150) NOT NULL,
user_id INT (50),
photo VARCHAR(20),
verification_code VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($mysql->query($sql) === TRUE) {
  echo "Table users created successfully\n";
} else {
  echo "Error creating table: " . $mysql->error;
}

?>
