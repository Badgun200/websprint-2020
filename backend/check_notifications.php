<?php
include("../config/db.php");
include("notification_send.php");

$time = time();
$query = "SELECT name, room, users, startTime FROM Seminars WHERE $time <= startTime AND startTime-$time <= 10*60;";
$result = mysqli_query($connect, $query);
if($result === false){
    die("Database error");
}

while($row = mysqli_fetch_array($result)){
    $seminar_name = $row[0];
    $room_num = $row[1];
    $userids_csv = explode(",", $row[2]);
    foreach($userids_csv as $userid){
        $query2 = "SELECT email FROM Users WHERE id = '$userid';";
        $result2 = mysqli_query($connect, $query2);
        $email = null;
        while($row2 = mysqli_fetch_array($result2)){
            $email = $row2[0];
        }
        echo $row[3]."<br>";
        echo time()."<br>";
        $remaining_time_minutes = round(($row[3]-time())/60);
        $subject = "$seminar_name starts in $remaining_time_minutes minutes!";
        $message = "Hey,\n$seminar_name starts soon in room no. $room_num!";
        if(notification_send($email, $subject, $message)){
            echo "OK for $email.<br>\n";
        }else{
            echo "ERROR for $email.<br>\n";
        }
    }
}
?>
