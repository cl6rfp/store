<?php

include 'config.php';

    header("Access-Control-Allow-Origin: *");


//This will contain a array of your data from database
$result_array = array();

//This will select the specified columns-rows from the database
$sql = "SELECT item, brand, image, info, price, stock FROM items ";
    
    /* If there are results from database push to result array */
    $result = $mysql->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
    }
    
    /*This will send a JSON encded array to client */
  echo json_encode($result_array);
    $mysql->close();
    
    
?>
