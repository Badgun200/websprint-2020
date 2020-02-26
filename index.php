<?php
session_start();
if(empty($_SESSION['email'])){
    include("static/index.html");
}
elseif($_SESSION['role'] === "admin"){
    require("backend/admin_interface.php");
    require("static/logout.html");
}else{
    require "backend/choose_seminars.php";
    require 'static/logout.html'; 
}
?>
