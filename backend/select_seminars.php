<?php
session_start();
$seminarsselected = $_POST['formsem'];
require '../config/db.php';
foreach($seminarsselected as &$semid){
    $_SESSION['seminars']=strval($_SESSION['seminars']).",".strval($semid);    
}
echo $_SESSION['seminars'];
$stmt = "UPDATE Users SET seminars='".$_SESSION['seminars']."' WHERE email='".mysqli_real_escape_string($connect,$_SESSION['email'])."'";
mysqli_query($connect, $stmt);

?>