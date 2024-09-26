<?php

include 'config.php';

header("Access-Control-Allow-Origin: *");

$email = "";

$type = $_POST["type"];

if($type == "getData"){
    getData($mysql);
    
} else if($type == "updateData"){
    updateData($mysql);
}

function getData($mysql){

if(empty($_POST["email"])){

echo "Your id seems to be empty, please fill all the details.\n";


} else {

$email = $_POST["email"];

$check1 = $mysql->query("SELECT 1 FROM users WHERE email = '$email' LIMIT 1");

if($check1->fetch_row()){

$data = "SELECT * FROM users WHERE email ='". $email."'";
    $result = $mysql->query($data);

if ($result->num_rows > 0) {
   
    $row = $result->fetch_assoc(); 
    
 
        if($email == $row["email"]){
        
            echo "update accessed id=".$row["id"]."\n";
        } else {
            echo "update denied id=null\n";
        }
} else {
    echo "0 results";
}
} else {
echo "data null\n";
}
}
}


function updateData($mysql){
    
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    //This command will updated your data
    $update = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$id'";

if ($mysql->query($update) === TRUE) {
  echo "Record updated successfully<br>";
} else {
  echo "Error updating record: " . $mysql->error;
}

}
?>