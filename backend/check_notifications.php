<?php
include("../config/db.php");
include("notification_send.php");

$time = time()+10*60;
$query = "SELECT name, room, users, startTime FROM Seminars WHERE startTime <= '$time';";
$result = mysqli_query($connect, $query);
if($result === false){
    die("Database error");
}

while($row = mysqli_fetch_array($result)){
    $seminar_name = $row[0];
    $room_num = $row[1];
    $userids_csv = explode(",", $row[2]);
    foreach($users_csv as $userid){
        $userid = mysqli_escape_query($userid);
        $query2 = "SELECT email FROM Users WHERE id = '$userid';";
        $result2 = mysqli_query($connect, $query2);
        $email = null;
        while($row = mysqli_fetch_array($result2)){
            $email = $row[0];
        }
        $remaining_time_minutes = date("i",$row[3]-time());
        $subject = "$seminar_name starts in $remaining_time_minutes!";
        $message = "Hey,\n$seminar_name starts soon in room no. $room_num!";
        if(notification_send($email, $subject, $message)){
            echo "OK for $email";
        }else{
            echo "ERROR for $email";
        }
    }
}
?>
