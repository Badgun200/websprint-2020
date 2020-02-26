<!DOCTYPE html>
<?php
if(isset($_SESSION['msg'])){
    echo "<h5>".$_SESSION['msg']."</h5>\n";
}
include("static/admin_interface.html");
?>
