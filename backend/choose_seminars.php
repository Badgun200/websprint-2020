<?php
    require "config/db.php";
    echo '<form action="index.php?chosen=1" method="post">';
    $raw = mysqli_query($connect, "SELECT id, name, details, room, startTime, endTime FROM Seminars");
    $userd = mysqli_query($connect, "SELECT seminars FROM Users WHERE ID=".$_SESSION["id"]);
    $usersems = explode(",", $userd);
    $startimes = array();
    $endtimes = array();
    $ids = array();
    foreach ($usersems as &$sem) {
      $curr = mysqli_query($con, "SELECT startTime, endTime, id FROM Seminars WHERE id=".$sem);
      $row = mysqli_fetch_row($curr);
      array_push($startimes, $row[0]);
      array_push($endtimes, $row[1]);
      array_push($ids, $row[2]);
    }

    while($row = mysqli_fetch_array($raw)) {
      $start = date("H:i", $row[4]);
      $end = date("H:i", $row[5]);
      $day = date("d. m. Y", $row[4]);
      echo '<input type="checkbox" name="formSem[]" value="'.$row[0];
      for($i = 0; $i < count($startimes); $i++) {
        if(($startimes[$i] > $start && $startimes[$i] < $end) ||
         ($endtimes[$i] > $start && $endtimes[$i] < $end) && $ids[$i] != $row[0]) {
           echo '<div class="error">Daná akce se kryje s jinou. Upravte svůj výběr.</div>';
           break;
         }
      }
      if(in_array($row[0], $usersems)) {
          echo 'checked';
      }
      echo '><div class="sname">'.$row[1].'</div><div class="sdet">'.$row[2].'</div><div class="sroom">'.$row[3]
            .'</div><div class="sdate>"'.$start.' - '.$end.'  '.$day.'</div>';
    }

    echo '<input type="submit" name="formSubmit" value="Potvrdit"></form>';
 ?>
