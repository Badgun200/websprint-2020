<?php
if(isset($_POST['login'])||isset($_POST['signup'])){
    

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
            $sql = "SELECT * FROM Users WHERE email=?;";
            $stmt = mysqli_stmt_init($connect);
            if(mysqli_stmt_prepare($stmt, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdCheck = password_verify($password, $row['password']);
                    if($pwdCheck == true){
                        session_start();
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['seminars'] = $row['seminars'];
                        header("Location: index.php?login=success");
                        exit();
                    }
                    elseif($pwdCheck == false){
                        header("Location: index.php?error=wrongpw");
                        exit();
                    }
                    else{
                        header("Location: index.php?error=wrongpwll");
                        exit();
                    }
                }
                else{
                    header("Location: index.php?error=nouser");
                    exit();
                }
            }
            else{
            header("Location: index.php?error=sqlerror");
            exit();
            }
        }
        elseif(isset($_POST['signup'])){        
            $sql = "SELECT email FROM Users WHERE email=?";
            $stmt = mysqli_stmt_init($connect);
            if(mysqli_stmt_prepare($stmt, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($sql);
                if($resultCheck > 0){
                    header("Location: index.php?error=emailexists");
                    exit();
                }
                else{
                    $sql = "INSERT INTO Users (email, password, role) VALUES (?,?,?)";
                    $stmt = mysqli_stmt_init($connect);
                    if (!mysqli_stmt_prepare($stmt,$sql)) {
                        header("Location: index.php?error=sqlerror");
                        exit();
                    }
                    else{
                        $hashPwd=password_hash($password, PASSWORD_BCRYPT);
                        $role = "member";
                        mysqli_stmt_bind_param($stmt, "sss", $email, $hashPwd, $role);
                        mysqli_stmt_execute($stmt);
                        header("Location: index.php?signup=success");
                        exit();
                    }
                }              
            }
            
        }
    }
}
else{
    header('Location: index.php?error=button');
    exit();
}
?>