<?php
    require "config/db.php";
    echo '<form action="choose_seminars.php" method="post">';
    if(isset($_SESSION["chosen"])) {
    if($_SESSION["chosen"] == 1) {
      //send data to db
      $checked = $_POST["formSem"];
      $str = "";
      foreach($checked as &$check) {
        $str += $check.",";
      }

    }}
    else {
    $raw = mysqli_query($connect, "SELECT * FROM Seminars");
    $userd = mysqli_query($connect, "SELECT seminars FROM Users WHERE email=".$_SESSION["email"]);
    $usersems = explode(",", $userd);
    $startimes = array();
    $endtimes = array();
    $ids = array();
    foreach ($usersems as &$sem) {
      $curr = mysqli_query($connect, "SELECT startTime, endTime, id FROM Seminars WHERE id=".$sem);
      $row = mysqli_fetch_row($curr);
      array_push($startimes, $row[0]);
      array_push($endtimes, $row[1]);
      array_push($ids, $row[2]);
    }
    if(isset($_POST["formSem"])) $checked = $_POST["formSem"];
    else $checked = "";

    while($row = mysqli_fetch_array($raw)) {
      $start = date("H:i", $row[4]);
      $end = date("H:i", $row[5]);
      $day = date("d. m. Y", $row[4]);
      echo '<input type="checkbox" name="formSem[]" value="'.$row[0];

      if(!empty($checked)) {
      for($i = 0; $i < count($startimes); $i++) {
        if(($startimes[$i] > $start && $startimes[$i] < $end) ||
         ($endtimes[$i] > $start && $endtimes[$i] < $end) && $ids[$i] != $row[0]
          && in_array($ids[$i], $checked)) {
           echo '<div class="error">Daná akce se kryje s jinou. Upravte svůj výběr.</div>';
           break;
         }
         $_SESSION["chosen"] = 1;
      }
    }

      if(in_array($row[0], $usersems)) {
          echo 'checked';
      }
      echo '><div class="sname">'.$row[1].'</div><div class="sdet">'.$row[2].'</div><div class="sroom">'.$row[3]
            .'</div><div class="sdate>"'.$start.' - '.$end.'  '.$day.'</div>';
    }

    echo '<input type="submit" name="formSubmit" value="Potvrdit"></form>';
  }
 ?>
