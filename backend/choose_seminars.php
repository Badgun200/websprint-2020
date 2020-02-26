<?php
    require "config/db.php";
    echo '<form action="confirm_seminars.php" method="post">';
    $raw = mysqli_query($connect, "SELECT id, name, details, room FROM Seminars");
    while($row = mysqli_fetch_array($raw)) {
      echo '<input type="checkbox" name="formSem[]" value="'.$row[0].'"/><div class="sname">'
      .$row[1].'</div><div class="sdet">'
      .$row[2].'</div><div class="sroom">'.$row[3].'</div>';
    }

    echo '<input type="submit" name="formSubmit" value="Potvrdit"></form>';
 ?>
