<?php
session_start();
$seminarsselected = $_POST['formsem'];
require '../config/db.php';
foreach($seminarsselected as &$semid){
    $_SESSION['seminars']=strval($_SESSION['seminars']).",".strval($semid);    
}
echo $_SESSION['seminars'];
$stmt = "UPDATE Users SET seminars=".$_SESSION['seminars'];
mysqli_query($connect, $stmt);

?>