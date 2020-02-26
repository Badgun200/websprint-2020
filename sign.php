<?php
if(isset($_POST['login'])==false||isset($_POST['signup'])==false){
    header('Location: index.php');
    exit();
}
$email = $_POST['email'];
$password = $_POST['password'];
if(empty($email)||empty($password)){
    header('Location: index.php?error=emptyfields');
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?error=invalidmail');
    exit();
}
else{
    require "config/db.php";
    if(isset($_POST['login'])){

    }
    elseif(isset($_POST['signup'])){
        $sql = "SELECT email FROM Users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($sql);
        if($resultCheck > 0){
            header("Location: ../signup.php?error=uidexists");
            exit();
        }
        else {
            $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($sql);
            if($resultCheck > 0){
                header("Location: ../signup.php?error=emailexists");
                exit();
            }
            else{
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, roleUsers, vkey) VALUES (?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                header("Location: ../signup.php?error=sqlerror");
                exit();
                }
                else{
                $hashPwd=password_hash($pwd, PASSWORD_DEFAULT);
                $role = "member";
                $vkey = md5(time().$username);
                mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashPwd, $role, $vkey);
                mysqli_stmt_execute($stmt);
                require 'sendvkey.inc.php';
                $subject = "Registration";
                $body = 'Your verification url: <a href="https://www.quaky.cz/includes/verify.inc.php?token='.$vkey.'">Verify</a>';
                sendVkey($email,$subject,$body);
                header("Location: ../login.php?signup=success&verify=sent");
                exit();
                }
            }
            }        
        }
        }
    }
}
?>