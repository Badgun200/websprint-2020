<?php
    require "config/db.php";
    $raw = mysqli_query($connect, "SELECT seminars FROM Users WHERE ID=".$_SESSION["id"]);
    $seminars = explode(",", $raw);
    foreach ($seminars as &$sem) {
      $curr = mysqli_query($con, "SELECT name, details, room FROM Seminars WHERE id=".$sem);
      $row = mysqli_fetch_row($curr);
      echo '<div class="sname">'.$row[0].'</div><div class="sdet">'.$row[1].'</div><div class="sroom">'.$row[2].'</div>';
    }
 ?>
