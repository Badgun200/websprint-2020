<?php
    require 'constants.php';
    
    $connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    
    if(!$connect){
        die("Nelze se připojit k databázi");
    }
     
?>
