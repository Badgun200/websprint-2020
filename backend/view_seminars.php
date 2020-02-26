<?php
    require "config/db.php";
    echo '<form action="backend/select_seminars.php" method="post">';
    
    $sql = "SELECT * FROM Seminars";
    $result = $connect->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<input type='checkbox' name='".$row['id']."'>".$row['name'];
      }
    }

    echo '<input type="submit" name="formSubmit" value="Potvrdit"></form>';
  
?>
