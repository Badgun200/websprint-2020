<?php
session_start();
$seminarsselected = $_POST['formsem'];
require '../config/db.php';
foreach($seminarsselected as &$semid){
    $_SESSION['seminars']=$_SESSION['seminars']+strval($semid);    
}
mysqli_query($connect, "UPDATE Users SET seminars=".$_SESSION['seminars']." WHERE id=".$_SESSION['id']."");

?>