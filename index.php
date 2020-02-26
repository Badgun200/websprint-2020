<?php
session_start();
if(empty($_SESSION['email'])){
    include("static/index.html");
}
else{
    require "backend/view_seminars.php";
    require 'static/logout.html';
}
?>
