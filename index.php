<?php
session_start();
if(empty($_SESSION['email'])){
    include("static/index.html");
}
else{
    require "backend/view_seminars.php";
    require 'static/logout.html';
    require 'backend/notification_send.php';
    echo notification_send("kvaky.kratschmer@gmail.com","subject","text");    
}
?>
